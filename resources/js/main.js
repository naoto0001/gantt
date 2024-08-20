
// // if (tasks.length !== 0) {
// let gantt = new Gantt("#gantt", tasks, {
//   on_click: (task) => {
//     console.log(task.description);
//   },
//   on_date_change: (task, start, end) => {
//     console.log(`${task.name}: change date to ${start} - ${end}`);
//     ajaxRequest(task, start, end);
//   },
//   on_progress_change: (task, progress) => {
//     console.log(`${task.name}: change progress to ${progress}%`);
//   },
//   view_mode: 'Day',
//   date_format: "YYYY-MM-DD",
//   header_height: 50,
// });
// };

// let gantt = new Gantt("#gantt", [], {});


const ajaxGet = function() {
  return $.ajax({
    type: "GET",
    url: "/ajax_data",
    dataType: "json",
  })
};

ajaxGet()
  .done((res) => {
    console.log('Fetched data:', res);
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

    // Initialize the Gantt chart with the fetched res_tasks

    console.log('Valid res_tasks:', res_tasks); // Log the valid res_tasks

    // let gantt = ("#gantt", res_tasks, {
    //     on_click: (task) => {
    //       console.log(task.description);
    //     },
    //     on_date_change: (task, start, end) => {
    //       console.log(`${task.name}: change date to ${start} - ${end}`);
    //       // ajaxRequest(task, start, end);
    //     },
    //     on_progress_change: (task, progress) => {
    //       console.log(`${task.name}: change progress to ${progress}%`);
    //     },
    //     view_mode: 'Day',
    //     date_format: "YYYY-MM-DD",
    //     header_height: 50,
    //   });
    console.log(res_tasks);
    // gantt.tasks[0].name = "資材発注2";
    // console.log(gantt.tasks[0].name);
    // gantt = new Gantt("#gantt", gantt.tasks);
    
    let tasks = [];
    res_tasks.forEach(task => {
      tasks.push({
        id: String(task.id),
        name: task.name,
        description: task.description,
        start: task.start,
        end: task.end,
        progress: task.progress,
      });
    });
    console.log(tasks);
    if (tasks && tasks.length > 0) {
        try {
          console.log("Initializing Gantt chart with tasks:", tasks);
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
          ajaxRequest(task, start, end);
        },
        on_progress_change: (task, progress) => {
          console.log(`${task.name}: change progress to ${progress}%`);
        },
        view_mode: 'Day',
        date_format: "YYYY-MM-DD",
        header_height: 50,
      });
    } catch (error) {
      console.error("Error initializing Gantt chart:", error);
    }
  };

const ajaxRequest = (task, start, end) => {
    $.ajax({
      type: "POST",
      url: "/gantt",
      dataType: "json",
      data: {
          "_token": $('meta[name="csrf-token"]').attr('content'), // Fetch CSRF token from meta tag
          id: Number(task.id),
          start: start,
          end: end,
      },
    })
    .done(function(res) {
      console.log(res.gantt);
      alert("Update method reached: " + JSON.stringify(res));
      // gantt = new Gantt("#gantt", tasks);
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
      console.error("Ajax request failed:", jqXHR,textStatus, errorThrown);
      alert("Update method failed: " + JSON.stringify(jqXHR));
    });
};
        
    function changeValue(event) {
      console.log(event.currentTarget.value);
      value = event.currentTarget.value;
    };
  
    export function recerveValue(){
      tasks[0].name = value;
      console.log(tasks[0].name);
      let gantt = new Gantt("#gantt", tasks);
      return gantt;
    };

    export function addValue(){
      console.log(tasks.length);
      tasks.push({
        id: '5',
        name: '資材発注',
        description: '資材の在庫を確認して発注する',
        start: '2024-08-16',
        end: '2024-08-25',
        progress: 20,
      });
      gantt = new Gantt("#gantt", tasks);
      return gantt;
    };