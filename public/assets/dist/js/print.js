function printDiv(elementToPrint) {

	var divToPrint = document.getElementById(elementToPrint).innerHTML;
	var orginal = document.body.innerHTML;
  
	document.body.innerHTML = divToPrint;
	window.print();
	document.body.innerHTML = orginal;
	document.location.reload(true);

	// var divToPrint = document.getElementById(elementToPrint).innerHTML;

	// var mywindow = window.open('?','_self');
 //    var is_chrome = Boolean(mywindow.chrome);
 //    mywindow.document.write(divToPrint);

 //    if (is_chrome) {
 //        setTimeout(function () { // wait until all resources loaded 
 //                mywindow.document.close(); // necessary for IE >= 10
 //                mywindow.focus(); // necessary for IE >= 10
 //                mywindow.print();  // change window to winPrint
 //                mywindow.close();// change window to winPrint
 //                document.location.reload(true);
 //        }, 250);
 //    }
 //    else {
 //        mywindow.document.close(); // necessary for IE >= 10
 //        mywindow.focus(); // necessary for IE >= 10

 //        mywindow.print();
 //        mywindow.close();
 //        document.location.reload(true);
 //    }
}
