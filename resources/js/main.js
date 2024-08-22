const monthNames = {
  "January": "1月",
  "February": "2月",
  "March": "3月",
  "April": "4月",
  "May": "5月",
  "June": "6月",
  "July": "7月",
  "August": "8月",
  "September": "9月",
  "October": "10月",
  "November": "11月",
  "December": "12月"
};

const ajaxGet = function() {
  return $.ajax({
    type: "GET",
    url: "/ajax_data",
    dataType: "json",
  })
};

ajaxGet()
  .done((res) => {
    // console.log('Fetched data:', res);
    const getTasks = res; // Assign the response to tasks
    let res_tasks = getTasks.filter(task => {
      if (!task.hasOwnProperty('id') || !task.hasOwnProperty('name') || !task.hasOwnProperty('start') || !task.hasOwnProperty('end')) {
        console.error('Task data is missing required properties:', task);
        return false;
      }
      return true;
    });

    if (res_tasks.length === 0) {
      console.error('No valid res_tasks to display.');
      return;
    }
    
    let tasks = [];
    res_tasks.forEach(task => {
      tasks.push({
        id: String(task.id),
        name: task.name,
        start: task.start,
        end: task.end,
        // progress: task.progress,
      });
    });
    if (tasks && tasks.length > 0) {
        try {
          // console.log("Initializing Gantt chart with tasks:", tasks);
          initializeGantt(tasks);
        } catch (error) {
          console.error("Error initializing Gantt chart:", error);
        }
      } else {
        console.error("No tasks available to initialize the Gantt chart.");
      }
    })
    .fail((error) => {
    console.log(error.statusText);
  });

  const initializeGantt = (tasks) => {
    try {
      let gantt = new Gantt("#gantt", tasks, {
        on_click: (task) => {
          console.log(task.description);
        },
        on_date_change: (task, start, end) => {
          console.log(`${task.name}: change date to ${start} - ${end}`);
          ajaxRequestDate(task, start, end);
        },
        // on_progress_change: (task, progress) => {
        //   console.log(`${task.name}: change progress to ${progress}%`);
        //   ajaxRequestProgress(task, progress);
        // },
        view_mode: 'Day',
        date_format: "YYYY-MM-DD",
        header_height: 49,
        bar_height: 15,
      });

      document.querySelectorAll('.upper-text').forEach(element => {
        const englishMonth = element.textContent.trim();
        if (monthNames[englishMonth]) {
            element.textContent = monthNames[englishMonth];
        }
    });

    } catch (error) {
      console.error("Error initializing Gantt chart:", error);
    }
  };

  const ajaxRequestDate = (task, start, end) => {
      $.ajax({
        type: "POST",
        url: "/gantt_update",
        dataType: "json",
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            id: Number(task.id),
            start: start,
            end: end,
        },
      })
      .done(function(res) {
        console.log(res.gantt);
        alert("日付が変更されました。");
        window.location.reload();
      })
      .fail(function(jqXHR, textStatus, errorThrown) {
          console.error("Ajax request failed:", jqXHR, textStatus, errorThrown);
          alert("Update method failed: " + JSON.stringify(jqXHR));
      });
  };

  $(document).ready(function() {
    const form = $('#ganttForm');
    const submitButton = $('#submitButton');

    submitButton.prop('disabled', true);

    form.on('input', function() {
        let allFilled = true;
        form.find('input[required]').each(function() {
            if ($(this).val() === '') {
                allFilled = false;
                return false;
            }
        });

        submitButton.prop('disabled', !allFilled);
    });

    form.on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {                
                alert("依頼を作成しました。");
                window.location.reload();
            },
            error: function(xhr) {
                // エラー時の処理
                var errors = xhr.responseJSON.errors;
                var errorMessages = '';

                $.each(errors, function(key, value) {
                    errorMessages += value[0] + '<br>';
                });

                $('#errorAlert').html(errorMessages).show();
            }
        });
    });
});

const deleteTask = (id) => {
  $.ajax({
    type: "POST",
    url: "/gantt_destroy",
    dataType: "json",
    data: {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        id: id,
    },
  })
  .done(function(res) {
    console.log(res.gantt);
    alert("消去しました。");
    window.location.reload();
  })
  .fail(function(jqXHR, textStatus, errorThrown) {
      console.error("Ajax request failed:", jqXHR, textStatus, errorThrown);
      alert("Delete method failed: " + JSON.stringify(jqXHR));
  });
};

export function deleteOn(id) {
  console.log(id);
  if (id) {
      deleteTask(id);
      return
    } else {
      console.error("No task ID provided to delete.");
      return
  };
};


  

