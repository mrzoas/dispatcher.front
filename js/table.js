var json_obj = '{"table_data":[{"id":1,"type":"Нет напора воды в кране ГВС","address":"ул. Грибоедова, д. 10а","flat":"129","date":"19.09.2019","end_date":"30.09.2019","state":"выполнено"},{"id":2,"type":"Протечка кровли","address":"ул. Ленина, д. 89","flat":"5","date":"24.09.2019","end_date":"28.09.2019","state":"отменено"},{"id":3,"type":"Неисправное освещение лифта","address":"ул. Проспект победы, стр. 15/10","flat":"","date":"29.09.2019","end_date":"04.10.2019","state":"просрочено"}]}';

var obj = JSON.parse(json_obj);

var tbody = document.getElementById('tbody'); 
obj.table_data.forEach(function callback(currentItem)
{
	//console.log(currentItem.id);
	const newTr = `
	<tr class="hide">
  	<td class="pt-3-half text-wrap text-break" contenteditable="false">${currentItem.id}</td>
  	<td class="pt-3-half text-wrap text-break" contenteditable="true">${currentItem.type}</td>
  	<td class="pt-3-half text-wrap text-break" contenteditable="true">${currentItem.address}</td>
 	<td class="pt-3-half text-wrap text-break" contenteditable="true">${currentItem.flat}</td>
  	<td class="pt-3-half text-wrap text-break" contenteditable="false">${currentItem.date}</td>
  	<td class="pt-3-half text-wrap text-break" contenteditable="true">${currentItem.end_date}</td>
  	<td class="pt-3-half text-wrap text-break" contenteditable="true">${currentItem.state}</td>
  	<td>
    	<span class="table-add"><button type="button" class="btn btn-danger btn-rounded btn-sm my-0 waves-effect waves-light">Сохранить</button></span>
    	<span class="table-remove"><button type="button" class="btn btn-danger btn-rounded btn-sm my-0 waves-effect waves-light">Удалить</button></span>
  	</td>
	</tr>`;

 	$('tbody').prepend(newTr);
});

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
  <td class="pt-3-half text-wrap text-break" contenteditable="false">~</td>
  <td class="pt-3-half text-wrap text-break" contenteditable="true"></td>
  <td class="pt-3-half text-wrap text-break" contenteditable="true"></td>
  <td class="pt-3-half text-wrap text-break" contenteditable="true"></td>
  <td class="pt-3-half text-wrap text-break" contenteditable="false">${dd}</td>
  <td class="pt-3-half text-wrap text-break" contenteditable="true"></td>
  <td class="pt-3-half text-wrap text-break" contenteditable="true"></td>
  <td>
    <span class="table-add"><button type="button" class="btn btn-danger btn-rounded btn-sm my-0 waves-effect waves-light">Сохранить</button></span>
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