var printer = null;
var ePosDev = null;
var isRegPrintConnected = true;
// var printerPort = 8043;
var printerPort = 8008;
var ipAddress = null;

var kPrinter = null;
var kePosDev = null;
// var kPrinterPort = 8043;
var printerPort = 8008;
var kIPAddress = null;

function InitKitchenPrinter() {
	console.log("Init Kitchen Printer");
	kIPAddress = getStorage("kitchenip");
	if (kIPAddress == '' || kIPAddress == "") {
		console.log("No Kitchen Printer configured")
	}
	else {
		$(".kitchen-printer-text").css("display", "inline");
		$(".kitchen-printer-status").css("display", "inline");
		$(".kitchen-printer-text").css("color", "black");
		$(".kitchen-printer-status").css("color", "yellow");
		kePosDev = new epson.ePOSDevice();
		kePosDev.connect(kIPAddress, kPrinterPort, kcbConnect);
	}
}

//Printing
function kcbConnect(data) {
	if (data == 'OK' || data == 'SSL_CONNECT_OK') {
		kePosDev.createDevice('local_printer', kePosDev.DEVICE_TYPE_PRINTER,
			{ 'crypto': false, 'buffer': true }, kcbCreateDevice_printer);
	} else {
		console.log("Kitchen Printer" + data);

	}
}

function kcbCreateDevice_printer(devobj, retcode) {
	if (retcode == 'OK') {
		kPrinter = devobj;
		kPrinter.timeout = 60000;
		kPrinter.onreceive = function (res) { //alert(res.success);
			console.log("Kitchen Printer Object Created");

		};
		$(".kitchen-printer-status").css("color", "#2c9f2c");
		kPrinter.oncoveropen = function () {
			alert('coveropen');
			console.log("Printer Cover Open");

		};
	} else {
		console.log(retcode);
		//isRegPrintConnected = false;
	}
}

function startMonitor() { //Starts the status monitoring process
	printer.startMonitor();
}
//Opens the printer cover
function stopMonitor() { //Stops the status monitoring process 
	printer.stopMonitor();
}

function InitMyPrinter() {
	console.log("Initializing Printer");
	$(".printer-status").css("color", "yellow");
	ipAddress = getStorage("primaryip");
	if(ipAddress == null) {
		$(".printer-status").css("color", "#dd2c33");
	//	GetPrinterIP();
	}
	if(kIPAddress == null) {
		$(".kitchen-printer-text").css({"display":"none"});
		$(".kitchen-printer-status").css({"display":"none"});
	}
	else {
		$(".kitchen-printer-text").css({"display":"inline"});
		$(".kitchen-printer-status").css({"display":"inline"});
	}
	ePosDev = new epson.ePOSDevice();
	ePosDev.connect(ipAddress, printerPort, cbConnect);
	ePosDev.onreconnecting = OnReconnecting;
	ePosDev.onreconnect = OnReconnect;
	ePosDev.ondisconnect = OnDisconnect;
}

function getStorage(key) {
	return localStorage.getItem(key);
}

function OnReconnecting() {
	console.log('onreconnecting');
	$(".printer-status").css("color", "#f0ad4e");
}

function OnReconnect() {
	console.log('onreconnect');
	$(".printer-status").css("color", "#2c9f2c");
}

function OnDisconnect() {
	console.log('ondisconnect');
	$(".printer-status").css("color", "#dd2c33");
}
function OnOnline() {
	console.log('Printer is online');
	$(".printer-status").css("color", "#2c9f2c");
}

function OnOffline() {
	console.log('Printer is offline');
	$(".printer-status").css("color", "#dd2c33");
}

function OnPowerOff() {
	console.log('Printer is switched off');
	$(".printer-status").css("color", "#dd2c33");
}

function OnCoverOk() {
	
	$(".printer-status").css("color", "#2c9f2c");
}

function OnPaperNearEnd() {
	
	alert("Paper is about to finish. Please be aware.");
}

function OnPaperEnd() {
	
	alert("Please reload paper");
}


function connect() {
	if(printer != null) {
		stopMonitor();
	}
	
	ipAddress = getStorage("primaryip");
	kIPAddress = getStorage("kitchenip");
	ePosDev = new epson.ePOSDevice();
	ePosDev.connect(ipAddress, printerPort, cbConnect);
	ePosDev.onreconnecting = OnReconnecting;
	ePosDev.onreconnect = OnReconnect;
	ePosDev.ondisconnect = OnDisconnect;

	if(kIPAddress == null || kIPAddress == "") {
		$(".kitchen-printer-text").css({"display":"none"});
		$(".kitchen-printer-status").css({"display":"none"});
	}
	else {
		$(".kitchen-printer-text").css({"display":"inline"});
		$(".kitchen-printer-status").css({"display":"inline"});
	}
}

//Printing
function cbConnect(data) {
	if (data == 'OK' || data == 'SSL_CONNECT_OK') {
		ePosDev.createDevice('local_printer', ePosDev.DEVICE_TYPE_PRINTER,
			{ 'crypto': false, 'buffer': true }, cbCreateDevice_printer);
	} else {
		console.log(data);
		$(".printer-status").css("color", "#dd2c33");
	}
}

function cbCreateDevice_printer(devobj, retcode) {
	if (retcode == 'OK') {
		printer = devobj;
		printer.timeout = 60000;
		printer.onreceive = function (res) { //alert(res.success);
			console.log("Printer On receive "+res);

		};
		startMonitor();
		printer.ononline = OnOnline;
		printer.onoffline = OnOffline;
		printer.onpoweroff = OnPowerOff;
		printer.onpapernearend = OnPaperNearEnd;
		printer.onpaperend = OnPaperEnd;
		printer.oncoveropen = function () {
			alert('printer cover open');
			console.log("Printer Cover Open");
			$(".printer-status").css("color", "#dd2c33");

		};
	} else {
		console.log(retcode);
		isRegPrintConnected = false;
	}
}


function printDriverSummary() {
	//getStorage("orderSummary");
	var pSummary = JSON.parse(getStorage("driverSummary"));
	console.log(pSummary);
	printer.addTextSmooth(true);
	printer.addTextAlign(printer.ALIGN_CENTER);
	printer.addTextDouble(true, true);
	printer.addText('Cuisine.JE\n Driver Summary' + '\n');
	printer.addTextSize(1, 1); // add 3 for kitchen
	printer.addText('\n----------------------------------------------');
	printer.addText('\n*www.cuisine.je*\n');
	var currentdate = new Date();
	printer.addText(currentdate.toLocaleString("en-UK") + '\n');
	printer.addTextAlign(printer.ALIGN_LEFT);

	printer.addTextSize(1, 1);
	printer.addTextStyle(false, false, true, printer.COLOR_1);

	printer.addTextAlign(printer.ALIGN_CENTER);
	printer.addTextSize(1, 1);
	printer.addText('\n----------------------------------------------\n');

	printer.addTextAlign(printer.ALIGN_LEFT);
	if (pSummary.length > 0) {
		printer.addText('Name\tOrder\tTime\tPayment\t  Amount\n');
		printer.addText('----------------------------------------------\n');
		$.each(pSummary, function (key, val) {

			printer.addText(val.driver_name + '\t' + val.order_id + '\t' + val.delivery_time + '\t' + val.payment_type + '\t£' + parseFloat(val.total_w_tax).toFixed(2) + '\n');

		});

	}
	else {
		printer.addText('\nNone\n');
	}

	printer.addText('\n');

	printer.addCut(printer.CUT_FEED);
	sendMessage();

}

function printSummary() {
	//getStorage("orderSummary");
	var pSummary = JSON.parse(getStorage("orderSummary"));
	console.log(pSummary);
	printer.addTextSmooth(true);
	printer.addTextAlign(printer.ALIGN_CENTER);
	printer.addTextDouble(true, true);
	printer.addText('Cuisine.JE\n Order Summary' + '\n');
	printer.addTextSize(1, 1); // add 3 for kitchen
	printer.addText('\n----------------------------------------------');
	printer.addText('\n*www.cuisine.je*\n');
	var currentdate = new Date();
	printer.addText(currentdate.toLocaleString("en-UK") + '\n');
	printer.addTextAlign(printer.ALIGN_LEFT);

	var total = 0;

	printer.addTextSize(1, 1);
	printer.addTextStyle(false, false, true, printer.COLOR_1);

	printer.addText('\n Accepted Orders -> ' + pSummary.accepted_order_count);
	printer.addText('\n Declined Orders -> ' + pSummary.declined_order_count);
	printer.addText('\n Total Payments £' + parseFloat(pSummary.cash_total + pSummary.citypay_total + pSummary.paypal_total).toFixed(2)); //to be fixed as cash total gives 0 in string

	if (pSummary.citypay_total != 0) {
		printer.addText('\n Citypay \t£' + parseFloat(pSummary.citypay_total).toFixed(2) + ' (' + pSummary.citypay_count + ')');
	}
	else {
		printer.addText('\n Citypay ' + "None");
	}


	if (pSummary.paypal_total != 0) {
		printer.addText('\n PayPal\t £' + parseFloat(pSummary.paypal_total).toFixed(2) + ' (' + pSummary.paypal_count + ')');
	}
	else {
		printer.addText('\n PayPal ' + "None");
	}

	if (pSummary.cash_total != 0) {
		printer.addText('\n CASH \t£' + pSummary.cash_total + ' (' + pSummary.cash_count + ')');
	}
	else {
		printer.addText('\n Citypay ' + "None");
	}




	printer.addTextAlign(printer.ALIGN_CENTER);
	printer.addTextSize(1, 1);
	printer.addText('\n\nAccepted\n----------------------------------------------\n');

	printer.addTextAlign(printer.ALIGN_LEFT);
	if (pSummary.accepted_order.length > 0) {
		printer.addText('Time\tID\tPayment\tAmount\n');
		printer.addText('----------------------------------------------\n');
		$.each(pSummary.accepted_order, function (key, val) {

			printer.addText(val.ordered_time + '\t' + val.order_id + '\t' + val.payment_type + '\t' + parseFloat(val.total_w_tax).toFixed(2) + '\n');
			total += parseFloat(val.total_w_tax);
		});

		printer.addText('\nTOTAL\t\t\t£' + total.toFixed(2));
	}
	else {
		printer.addText('\nNone\n');
	}

	var total1 = 0;

	printer.addTextAlign(printer.ALIGN_CENTER);
	printer.addText('\n\nDeclined\n----------------------------------------------\n');
	printer.addTextAlign(printer.ALIGN_LEFT);
	if (pSummary.declined_order.length > 0) {
		printer.addText('Time\tID\tPayment\tAmount\n');
		printer.addText('----------------------------------------------\n');
		$.each(pSummary.declined_order, function (key, val) {

			printer.addText(val.ordered_time + '\t' + val.order_id + '\t' + val.payment_type + '\t' + parseFloat(val.total_w_tax).toFixed(2) + '\n');
			total1 += parseFloat(val.total_w_tax);
		});

		printer.addText('TOTAL\t\t\t\t£' + total1.toFixed(2));
	}
	else {
		printer.addText('\nNone\n');
	}

	printer.addTextStyle(false, false, false, printer.COLOR_1);
	printer.addText('\n');

	printer.addCut(printer.CUT_FEED);
	sendMessage();

}

function printTbl() {
	var merchantInfo = JSON.parse(getStorage("merchant_info"));
	var order = JSON.parse(getStorage("tabledetails"));

	console.log("Printing Started");
	addLogo();
	printer.addTextAlign(printer.ALIGN_CENTER);
	printer.addTextSmooth(true);
	//printer.addText('\n');
	//printer.addText('\n');

	printer.addTextDouble(true, true);
	printer.addText('Cuisine.JE' + '\n');
	printer.addTextDouble(false, false);
	printer.addText('Jersey\'s new food and table booking platform' + '\n');
	printer.addText('\n');
	// Restaurant Information here
	printer.addTextDouble(true, true);
	printer.addTextAlign(printer.ALIGN_CENTER);
	printer.addText(merchantInfo.restaurant_name + '\n');
	printer.addTextDouble(false, false);
	printer.addTextStyle(false, false, false, printer.COLOR_1);
	printer.addTextDouble(true, true);
	printer.addText('* TABLE COPY * #' + order.booking_id);

	printer.addTextDouble(false, false);
	printer.addTextSize(1, 1); // add 3 for kitchen
	printer.addText('\n----------------------------------------------\n');

	printer.addTextAlign(printer.ALIGN_LEFT);

	printer.addText('Name:\t\t' + order.booking_name);
	printer.addText('\nPhone:\t\t' + order.mobile);
	printer.addText('\nInstructions:\n' + order.booking_notes);

	printer.addTextSize(2, 2);

	var dType = '\nTable booked for\n';
	printer.addText('\n' + dType);
	printer.addTextStyle(true, true, true, printer.COLOR_1);
	printer.addText(order.date_booking + ' ');
	printer.addText(order.booking_time);

	//printer.addTextSize(1,1);
	printer.addTextStyle(false, false, false, printer.COLOR_1);

	printer.addText('\nGuests:\t\t' + order.number_guest);
	printer.addTextSize(1, 1);
	printer.addText('\n----------------------------------------------');
	printer.addText('\n\n');
	printer.addCut(printer.CUT_FEED);
	sendMessage();
}

function print() {
	var merchantInfo = JSON.parse(getStorage("merchant_info"));
	var order = JSON.parse(getStorage("printdetails"));
	var customer = order.client_info;

	var pricing = order.total;


	//debugger;
	if (isRegPrintConnected == false || printer == null) {
		console.log("Printer is null");
		return;
	}
	console.log("Printing Started");
	addLogo();
	printer.addTextAlign(printer.ALIGN_CENTER);
	printer.addTextSmooth(true);
	//printer.addText('\n');
	//printer.addText('\n');

	printer.addTextDouble(true, true);
	printer.addText('Cuisine.JE' + '\n');
	printer.addText('*www.cuisine.je*\n');
	printer.addTextDouble(false, false);
	printer.addText('Jersey\'s new food and table booking platform' + '\n');
	printer.addText('\n');
	// Restaurant Information here
	printer.addTextDouble(true, true);
	printer.addTextAlign(printer.ALIGN_CENTER);
	printer.addText(merchantInfo.restaurant_name + '\n');
	printer.addTextDouble(false, false);
	printer.addText(merchantInfo.street + ',' + merchantInfo.city + '\n' + merchantInfo.post_code + '\n');
	printer.addText('Phone:' + merchantInfo.restaurant_phone + '\n');
	//printer.addText(merchantInfo.restaurant_slug + '\n'); //Commented as currently its a lengthy url to remember.

	printer.addTextAlign(printer.ALIGN_CENTER);
	printer.addTextStyle(false, false, true, printer.COLOR_1);
	printer.addTextStyle(false, false, false, printer.COLOR_1);
	printer.addTextDouble(true, true);
	printer.addText('* CUSTOMER COPY *\n\n');
	addOrderDetails();

	printer.addText('\n\nFor order specific enquires , please contact \n' + merchantInfo.restaurant_name);
	printer.addText('\ncheck all deals at www.cuisine.je/deals or download our app by scanning the QR code on the top\n');
	//printer.addSymbol('https://www.cuisine.je/mobile', printer.SYMBOL_QRCODE_MODEL_1, printer.LEVEL_1, 2, 8, 0);
	//printer.addSymbol('https://www.cuisine.je/mobile', printer.SYMBOL_PDF417_STANDARD, printer.LEVEL_1, 2, 8, 0);

	printer.addCut(printer.CUT_FEED);
	// End of Customer Copy print

	printer.addTextDouble(true, true);
	printer.addTextAlign(printer.ALIGN_CENTER);
	printer.addText('*www.cuisine.je*\n');
	printer.addText('* RESTAURANT COPY *\n\n');
	addOrderDetails();
	printer.addText('\n\n This order is from www.cuisine.je, for business queries call us on +44 1534761135. \n thank you \n');
	printer.addCut(printer.CUT_FEED);

	printer.addTextDouble(true, true);
	printer.addTextAlign(printer.ALIGN_CENTER);
	printer.addText('* KITCHEN COPY *\n\n');
	addKitchenDetails();
	printer.addText('\n\n');
	printer.addCut(printer.CUT_FEED);
	sendMessage();


	if (kIPAddress != "" || kIPAddress != null) {
		printer = null;
		InitKitchenPrinter();
	}
	setTimeout(function () {
		if (kPrinter != null) {
			console.log("Kitchen printer is available and calling it to print");
			printToKitchen();
		}


	}, 5000);


}

function addKitchenDetails() {
	var data = JSON.parse(getStorage("printdetails"));
	var customer = data.client_info;
	printer.addTextAlign(printer.ALIGN_CENTER);

	if (data.trans_type == 'pickup' || data.trans_type == 'Pickup')
		printer.addText('Order:' + data.order_id + ' -> Collection');
	else
		printer.addText('Order:' + data.order_id + ' -> ' + data.trans_type);

	printer.addText('\n\nName: ' + customer.full_name);
	if (!empty(data.item)) {
		$.each(data.item, function (key, val) {
			if (val.item_name != null) {

				description = val.qty + "x  " + val.item_name;


				if (!empty(val.size_words)) {
					description += " (" + val.size_words + ")";
				}

				if (!empty(val.cooking_ref)) {
					description += '\n' + val.cooking_ref
				}

				if (!empty(val.order_notes)) {
					description += '\n' + val.order_notes
				}

				printer.addTextSize(2, 2);
				printer.addTextAlign(printer.ALIGN_LEFT);
				printer.addText('\n\n' + description + '\n');


				printer.addTextSize(2, 1);
				printer.addTextAlign(printer.ALIGN_RIGHT);
				/*ingredients*/
				if (!empty(val.ingredients)) {
					if (val.ingredients.length > 0) {
						//html+='\t\t'+ getTrans("Ingredients",'ingredients') +'\n';
						$.each(val.ingredients, function (key1, ingredients) {
							printer.addText('' + ingredients + '\n');
						});
					}
				}

				/*sub item add on*/

				if (!empty(val.sub_item_new)) {
					printer.addText('Add Ons:\n');
					$.each(val.sub_item_new, function (key2, sub_item) {
						//html+='\t\t'+key2+'\n';
						if (sub_item.length > 0) {
							$.each(sub_item, function (key3, sub_items) {
								t_desc = sub_items.addon_name;

								printer.addText(t_desc + '\n');


							});
						}
					});
				}
			}
		}); // end of $.each loop
	} //end of if !empty

}

function printToKitchen() {
	var data = JSON.parse(getStorage("printdetails"));
	var customer = data.client_info;
	kPrinter.addTextAlign(kPrinter.ALIGN_CENTER);
	console.log("Kitchen Printing Started");

	kPrinter.addTextDouble(true, true);
	kPrinter.addTextAlign(kPrinter.ALIGN_CENTER);
	kPrinter.addText('* KITCHEN COPY *\n\n');

	if (data.trans_type == 'pickup' || data.trans_type == 'Pickup')
		kPrinter.addText('Order:' + data.order_id + ' -> Collection');
	else
		kPrinter.addText('Order:' + data.order_id + ' -> ' + data.trans_type);

	kPrinter.addText('\n\nName: ' + customer.full_name);
	if (!empty(data.item)) {
		$.each(data.item, function (key, val) {
			if (val.item_name != null) {

				description = val.qty + "x  " + val.item_name;


				if (!empty(val.size_words)) {
					description += " (" + val.size_words + ")";
				}

				if (!empty(val.cooking_ref)) {
					description += '\n' + val.cooking_ref
				}

				if (!empty(val.order_notes)) {
					description += '\n' + val.order_notes
				}

				kPrinter.addTextSize(2, 2);
				kPrinter.addTextAlign(kPrinter.ALIGN_LEFT);
				kPrinter.addText('\n\n' + description + '\n');


				kPrinter.addTextSize(2, 1);
				kPrinter.addTextAlign(kPrinter.ALIGN_RIGHT);
				/*ingredients*/
				if (!empty(val.ingredients)) {
					if (val.ingredients.length > 0) {
						//html+='\t\t'+ getTrans("Ingredients",'ingredients') +'\n';
						$.each(val.ingredients, function (key1, ingredients) {
							kPrinter.addText('' + ingredients + '\n');
						});
					}
				}

				/*sub item add on*/

				if (!empty(val.sub_item_new)) {
					kPrinter.addText('Add Ons:\n');
					$.each(val.sub_item_new, function (key2, sub_item) {
						//html+='\t\t'+key2+'\n';
						if (sub_item.length > 0) {
							$.each(sub_item, function (key3, sub_items) {
								t_desc = sub_items.addon_name;

								kPrinter.addText(t_desc + '\n');


							});
						}
					});
				}
			}
		}); // end of $.each loop
	}


	kPrinter.addText('\n\n');
	kPrinter.addCut(kPrinter.CUT_FEED);
	kPrinter.send();

	kPrinter == null;
	//connect the printer again for next print.
	if (printer == null) {
		connect();
	}


}


function addOrderDetails() {

	var merchantInfo = JSON.parse(getStorage("merchant_info"));
	var order = JSON.parse(getStorage("printdetails"));
	var customer = order.client_info;

	var pricing = order.total;
	printer.addTextAlign(printer.ALIGN_LEFT);

	if (order.trans_type == 'pickup' || order.trans_type == 'Pickup')
		printer.addText('Order:' + order.order_id + ' -> Collection');
	else
		printer.addText('Order:' + order.order_id + ' -> ' + order.trans_type);

	printer.addTextDouble(false, false);
	printer.addTextSize(1, 1); // add 3 for kitchen
	printer.addText('\n----------------------------------------------');
	printer.addText('\nDate:\t\t' + order.transaction_date);
	printer.addText('\nName:\t\t' + customer.full_name);
	printer.addTextStyle(false, false, true, printer.COLOR_1);
	printer.addText('\nPhone:\t\t' + customer.contact_phone);


	if (order.trans_type == 'delivery') {
		printer.addText('\n\nDelivery Address:\n' + customer.address);
		var di = (order.delivery_instruction != "") ? order.delivery_instruction : "";
		//	dump(di);
		printer.addText('\n\nInstructions :\n' + di);
	}
	printer.addTextStyle(false, false, false, printer.COLOR_1);
	var dTime = (order.delivery_time != false) ? order.delivery_time : "NA";
	var asap = (order.delivery_asap == 'Yes') ? "(ASAP)" : "";
	//	printer.addTextFont(printer.FONT_C);
	printer.addTextSize(2, 2);

	var dType = 'Delivery date & time\n';
	if (order.trans_type == 'pickup' || order.trans_type == 'Pickup') {
		dType = 'Collection date & time\n';
	}
	printer.addText('\n\n' + dType);
	printer.addTextStyle(true, true, true, printer.COLOR_1);
	printer.addText(order.delivery_date + ' ');
	printer.addText(dTime + asap);

	//printer.addTextSize(1,1);
	printer.addTextStyle(false, false, false, printer.COLOR_1);

	printer.addText('\n\nOrder Details');
	printer.addTextSize(1, 1);
	printer.addText('\n----------------------------------------------\n');
	//Print the items
	printer.addTextStyle(false, false, true, printer.COLOR_1);
	addMenuItems();
	printer.addTextStyle(false, false, false, printer.COLOR_1);
	if (order.trans_type == 'delivery') {
		printer.addText('Delivery Fee\t\t\t\t ' + pricing.delivery_charges);
	}
	printer.addText('\n----------------------------------------------\n');
	printer.addTextSize(2, 2);
	printer.addText('Total\t\t\t' + pricing.total);
	printer.addTextSize(1, 1);
	//Footer print

	var payType = '';
	if (order.payment_type == 'COD' || order.payment_type == 'CASH') {
		payType = '\n\nCASH';
	}
	else if (order.payment_type == 'CITYPAY')
		payType = '\n\n' + order.payment_type;
	else
		payType = '\n\nPayPal';

	printer.addTextAlign(printer.ALIGN_CENTER);
	printer.addTextSize(4, 4);
	printer.addText(payType);
	printer.addTextSize(1, 1);
}

function formatLine(str) {
	var result = str.replace(/.{20}\S*\s+/g, "$&@").split(/\s+@/);
	var tol_space = 32 - (result.join("\n").length);
	var empty_space = ' ', tol_spaces = '';
	//alert(result.join("\n").length);
	if (result.join("\n").length >= 22) {
		var newresult = str.replace(/.{20}\S*\s+/g, "$&@").split(/\s+@/);
		tol_space = 32 - $(newresult).last()[0].length;
	}

	for (var j = 0; j < tol_space; j++) {
		tol_spaces += empty_space;
	}
}

function addMenuItems() {

	var data = JSON.parse(getStorage("printdetails"));
	if (!empty(data.item)) {
		$.each(data.item, function (key, val) {
			if (val.item_name != null) {
				//dump(val);
				var price = val.normal_price;
				if (val.discounted_price > 0) {
					price = val.discounted_price
				}


				var final_price = val.total_price;

				description = val.qty + "x  " + val.item_name;
				if (!empty(val.size_words)) {
					description += " (" + val.size_words + ")";
				}

				if (!empty(val.cooking_ref)) {
					description += '\n' + val.cooking_ref
				}

				if (!empty(val.order_notes)) {
					description += '\n' + val.order_notes
				}

				//Creating space and formatting the item _______________ price for the paper
				var result = description.replace(/.{28}\S*\s+/g, "$&@").split(/\s+@/);
				var tol_space = 41 - (result.join("\n").length);
				var empty_space = ' ', tol_spaces = '';
				//alert(result.join("\n").length);
				if (result.join("\n").length >= 30) {
					var newresult = description.replace(/.{28}\S*\s+/g, "$&@").split(/\s+@/);
					tol_space = 41 - $(newresult).last()[0].length;
				}

				for (var j = 0; j < tol_space; j++) {
					tol_spaces += empty_space;
				}


				printer.addTextAlign(printer.ALIGN_LEFT);
				printer.addText(result.join("\n") + tol_spaces);
				printer.addText(final_price + '\n');


				/*ingredients*/
				if (!empty(val.ingredients)) {
					if (val.ingredients.length > 0) {
						//html+='\t\t'+ getTrans("Ingredients",'ingredients') +'\n';
						$.each(val.ingredients, function (key1, ingredients) {
							printer.addText('\t' + ingredients + '\n');
						});
					}
				}

				/*sub item add on*/

				if (!empty(val.sub_item_new)) {
					$.each(val.sub_item_new, function (key2, sub_item) {
						//html+='\t\t'+key2+'\n';
						if (sub_item.length > 0) {
							$.each(sub_item, function (key3, sub_items) {
								t_desc = '       Add on:' + sub_items.addon_name;

								//format with text and spaces
								var result = t_desc.replace(/.{28}\S*\s+/g, "$&@").split(/\s+@/);
								var tol_space = 41 - (result.join("\n").length);
								var empty_space = ' ', tol_spaces = '';
								//alert(result.join("\n").length);
								if (result.join("\n").length >= 30) {
									var newresult = t_desc.replace(/.{28}\S*\s+/g, "$&@").split(/\s+@/);
									tol_space = 41 - $(newresult).last()[0].length;
								}

								for (var j = 0; j < tol_space; j++) {
									tol_spaces += empty_space;
								}
								printer.addText(result.join("\n") + tol_spaces);
								if (sub_items.total != 0)
									printer.addText(sub_items.total + '\n');
								else
									printer.addText('\n');

								//	html+=TPLorderRow( t_desc ,  sub_items.total , 'fixed-col' );
							});
						}
					});
				}
			}
		}); // end of $.each loop
	} //end of if !empty
} //end of function addMenuItems


// call the printer recover function
function sendRecover() {
	printer.recover();
}

// call the printer reset function
function sendReset() {
	printer.reset();
}

// send print data
function sendMessage() {
	var temp = printer.message;
	// send
	printer.send();
	printer.message = temp;
}

// Adds NV logo printing
function addLogo() {
	try {
		var key1 = 32;
		var key2 = 32;
		printer.addLogo(key1, key2);

	}
	catch (e) {
		alert("Printer is not reachable. Please refresh by pulling down or check your network");
	}
}


function printOrder() {
	getStorage("printdetails");
	var print_details = JSON.parse(getStorage("printdetails"));
	console.log(print_details);
	print(print_details);

}


function printTable() {
	var table_details = JSON.parse(getStorage("tabledetails"));
	console.log(table_details);
	printTbl();

}



setTimeout(() => {
	InitMyPrinter();
}, 5000);


