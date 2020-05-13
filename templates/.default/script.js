

function sendExcell(e){
    e.preventDefault(); // или return false;
    var form =  new FormData($("#send-excel")[0]);
    const file = $("#file");
    cleanError();
    cleanTable();
    
    $.ajax({
        type: "POST",
        url: "/bitrix/components/seva/tableImport/ajaxManager.php",
        data: form,
        cache: false,
            contentType: false,
            processData: false,
        success: function(resp){
            resp = JSON.parse(resp);
            if(typeof(resp.error) === "string")
                onError(resp.error);
            else
                printTable(resp)
            
        }
      });
}

function onError(msg)
{
    error = $("#error");
    error.attr("visibility", "visible");
    error.append(msg);
}

function cleanError(){
    error = $("#error")
    error.attr("visibility", "hidden");
    error.empty()
}

function cleanTable()
{
    let head = $("#tableProductHead")
    let body = $("#tableProductBody")

    head.empty()
    body.empty()

}

function printTable(tableValues)
{
    var tableHead = $("#tableProductHead")
    var tableBody = $("#tableProductBody")
    
    printTitle(tableHead, tableValues)

    printRows(tableBody, tableValues)
}

function printTitle(tableHead, titles)
{

    tableHead.append("<tr id=\"trTitle\"></tr>")
    tr = $("#trTitle");
    for(let title in titles){
    tr.append("<th>"+ title +"</th>")
    }
    
}

function printRows(tableBody, cells)
{
    countKeys = getCountKeys(cells);
    let cell;
    for(let i = 1; i < countKeys - 1; i++){
        tableBody.append("<tr id=\"trBody" + i + "\"></tr>")
        tr = $("#trBody" + i);
        for(let title in cells){
            cell = cells[title][i];
            if(typeof(cell) === "object")
                cell = "-";
            tr.append("<td>"+ cell+"</td>")
        }
    }
}

function getCountKeys(obj)
{
    var count = 0;
for(let key in obj){
    count++;
}
return count
}



