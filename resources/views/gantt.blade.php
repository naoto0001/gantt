<x-layout>
    
    <div class="container-fluid">
        <h1 class="m-3">工事名</h1>
        <p class="ms-5">山下浩二</p>
        <div class="container text-center h-auto m-auto">
            <div class="container">
                <div class="row h-auto">
                    <div class="col p-0 h-auto">                        
                        <h6 class="m-0 pb-1 border">依頼情報</h6>
                        <div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                    <th class="p-1" scope="col">消去</th>
                                    <th class="p-1" scope="col">依頼者</th>
                                    <th class="p-1" scope="col">製品</th>                                    
                                    </tr>
                                </thead>
                                <tbody class="gantt_tbody">                                
                                @foreach($gantt as $data)                                
                                <tr id="gantt_{{ $data->id }}">
                                    <td class="p-1">
                                        <button type="button" class="btn btn-secondary btn-sm"
                                            onclick="deleteOn({{ $data->id }})"
                                        >
                                        </button>
                                    </td>
                                    <td class="p-1" >{{ $data->client }}</td>
                                    <td class="p-1" colspan="2">{{ $data->parts }}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class='gantt-wrap col h-auto'>
                        <div class="gantt-target dark"></div>
                        <svg id="gantt"></svg>
                    </div>
                </div>
            </div>
        </div>
        <form class="g-3 ms-2 form-horizontal" action="{{ route('gantt.create')}}" method="post" id="ganttForm">
        <!-- <form class="g-3 ms-2 form-horizontal" action="{{ url('/gantt')}}" method="POST" id="ganttForm"> -->
            {{ csrf_field() }}
            <div id="errorAlert" style="display:none; color:red;"></div>
            <div class="row">
                <div class="col-2">
                    <label for="client" class="form-label">依頼者名</label>
                    <input type="text" id="client" class="form-control" name="client" required>
                </div>
                <div class="col-4">
                    <label for="parts" class="form-label">製品名</label>
                    <input type="text" id="parts" class="form-control" name="parts" required>
                </div>
            </div>
            <div class="row mt-1 mb-1">
                <div class="col-2">
                    <label for="name" class="form-label">依頼名</label>
                    <input type="text" id="name" class="form-control" name="name" required>
                </div>
                <div class="col-2">
                    <label for="start" class="form-label">依頼日</label>
                    <input type="date" id="start" class="form-control" name="start" required>
                </div>
                <div class="col-2">
                    <label for="end" class="form-label">終了予定日</label>
                    <input type="date" id="end" class="form-control" name="end" required>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <button type="submit" class="btn btn-primary mb-3" id="submitButton" disabled>依頼を追加</button>
                </div>
            </div>
        </form>
    </div>
</x-layout>