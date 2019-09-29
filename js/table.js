var obj = json_obj2;

var tbody = document.getElementById('tbody'); 
obj.tableData.forEach(function callback(currentItem)
{
	//console.log(currentItem.id);
	const newTr = `
	<tr class="hide">
  	<td class="pt-3-half text-wrap text-break active-warning" contenteditable="false">${currentItem.code}</td>
  	<td class="pt-3-half text-wrap text-break active-warning" contenteditable="true">${currentItem.text}</td>
  	<td class="pt-3-half text-wrap text-break active-warning" contenteditable="true">${currentItem.address != null ? currentItem.address : "" }</td>
 	<td class="pt-3-half text-wrap text-break active-warning" contenteditable="true">${currentItem.flat != null ? currentItem.flat : "" }</td>
  	<td class="pt-3-half text-wrap text-break active-warning" contenteditable="false">${currentItem.createDate != null ? currentItem.createDate : ""}</td>
  	<td class="pt-3-half text-wrap text-break active-warning" contenteditable="true">${currentItem.lastEditDate != null ? currentItem.lastEditDate: ""}</td>
  	<td class="pt-3-half text-wrap text-break active-warning" contenteditable="true">${currentItem.state != null ? currentItem.state : ""}</td>
  	<td>
    	<span class="table-add"><button type="button" id="save" class="btn btn-danger btn-calm btn-rounded btn-sm my-0 waves-effect waves-light">Сохранить</button></span>
    	<span class="table-remove"><button type="button" class="btn btn-danger btn-rounded btn-sm my-0 waves-effect waves-light">Удалить</button></span>
  	</td>
	</tr>`;

 	$('tbody').prepend(newTr);
});

/*
code: "dvHYR34"
createDate: null
eMail: null
executor: null
id: 1
lastEditDate: null
phone: null
service: null
text: "Крышу сорвало"
*/

const $tableID = $('#table');
const $BTN = $('#export-btn');
const $EXPORT = $('#export');
var date = new Date();
var values = [ date.getDate(), date.getMonth() + 1 ];
for( var id in values ) {
  values[ id ] = values[ id ].toString().replace( /^([0-9])$/, '0$1' );
}
var dd = values[ 0 ]+'.'+values[ 1 ]+'.'+date.getFullYear();

 const newTr = `
<tr class="hide">
  <td class="pt-3-half text-wrap text-break active-warning" contenteditable="false">~</td>
  <td class="pt-3-half text-wrap text-break active-warning" contenteditable="true"></td>
  <td class="pt-3-half text-wrap text-break active-warning" contenteditable="true"></td>
  <td class="pt-3-half text-wrap text-break active-warning" contenteditable="true"></td>
  <td class="pt-3-half text-wrap text-break active-warning" contenteditable="false">${dd}</td>
  <td class="pt-3-half text-wrap text-break active-warning" contenteditable="true"></td>
  <td class="pt-3-half text-wrap text-break active-warning" contenteditable="true"></td>
  <td>
    <span class="table-add"><button type="button" class="btn btn-danger btn-warning btn-rounded btn-sm my-0 waves-effect waves-light">Сохранить</button></span>
    <span class="table-remove"><button type="button" class="btn btn-danger btn-rounded btn-sm my-0 waves-effect waves-light">Удалить</button></span>
  </td>
</tr>`;

 $('.table-add').on('click', 'i', () => 
 {
    $('tbody').prepend(newTr);
 });

 $tableID.on('click', '.table-remove', function () {

   $(this).parents('tr').detach();
 });


 // A few jQuery helpers for exporting only
 jQuery.fn.pop = [].pop;
 jQuery.fn.shift = [].shift;

 $BTN.on('click', () => {

   const $rows = $tableID.find('tr:not(:hidden)');
   const headers = [];
   const data = [];

   // Get the headers (add special header logic here)
   $($rows.shift()).find('th:not(:empty)').each(function () {

     headers.push($(this).text().toLowerCase());
   });

   // Turn all existing rows into a loopable array
   $rows.each(function () {
     const $td = $(this).find('td');
     const h = {};

     // Use the headers from earlier to name our hash keys
     headers.forEach((header, i) => {

       h[header] = $td.eq(i).text();
     });

     data.push(h);
   });

   // Output the result
   $EXPORT.text(JSON.stringify(data));
 });

