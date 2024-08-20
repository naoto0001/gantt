<x-layout>
<div class="main">
        <h1>工事名</h1>
        <p>テスト</p>
        <div class="contents-wrapper">
            <!-- <div class="input-wrapper">
                <h2>課題入力</h2>
                <span class="inb"><input id="input1" class="inputs" type="text" value=""> <button onclick="recerveValue()">更新</button></span>
                <span class="inb"><input id="input2" class="inputs" type="text"> <button>更新</button></span>
                <span class="inb"><input id="input3" class="inputs" type="text"> <button>更新</button></span>
                <span class="inb"><input id="input4" class="inputs" type="text"> <button>更新</button></span>
            </div> -->
            <div class='gantt-wrap'>
            <div class="gantt-target dark"></div>
              <svg id="gantt"></svg>
            </div>
        </div>
        <button onclick="addValue()">更新</button>
        <button id="getUsersButton">Get Gantt</button>
    </div>
</x-layout>