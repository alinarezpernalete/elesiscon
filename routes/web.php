<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('home');
// ------------------------------------------------------------------------- //
Route::get('/exampleGraphic/index', 'ChartController@index')->name('exampleGraphic');
// ------------------------------------------------------------------------- //
Route::get('/provReport', 'HomeController@provReport')->name('provReport');
Route::get('/provReport/index', 'provReportController@index')->name('provReport');
Route::get('/provReport/byDate', 'provReportController@byDate')->name('provReport.byDate');
Route::get('/provReport/byStatus', 'provReportController@byStatus')->name('provReport.byStatus');
// ------------------------------------------------------------------------- //
Route::get('/custReport', 'HomeController@custReport')->name('custReport');
Route::get('/custReport/index', 'custReportController@index')->name('custReport');
Route::get('/custReport/byDate', 'custReportController@byDate')->name('custReport.byDate');
Route::get('/custReport/byStatus', 'custReportController@byStatus')->name('custReport.byStatus');
// ------------------------------------------------------------------------- //
Route::get('/providers', 'HomeController@providers')->name('providers');
Route::get('/providers/index', 'ProvidersController@index')->name('providers');
Route::post('/providers/store', 'ProvidersController@store')->name('providers.store');
Route::post('/providers/desactiveProvider', 'ProvidersController@desactiveProvider')->name('providers.desactiveProvider');
// ------------------------------------------------------------------------- //
Route::get('/customers', 'HomeController@customers')->name('customers');
Route::get('/customers/index', 'CustomersController@index')->name('customers');
Route::post('/customers/store', 'CustomersController@store')->name('customers.store');
Route::post('/customers/desactiveCustomer', 'CustomersController@desactiveCustomer')->name('customers.desactiveCustomer');
// ------------------------------------------------------------------------- //
Route::get('/ARReport', 'HomeController@articlesReport')->name('ARReport');
Route::get('/ARReport/index', 'ARReportController@index')->name('ARReport');
Route::get('/ARReport/byDate', 'ARReportController@byDate')->name('ARReport.byDate');
Route::get('/ARReport/byBank', 'ARReportController@byBank')->name('ARReport.byBank');
Route::get('/ARReport/byCurrency', 'ARReportController@byCurrency')->name('ARReport.byCurrency');
Route::get('/ARReport/byCustomer', 'ARReportController@byCustomer')->name('ARReport.byCustomer');
// ------------------------------------------------------------------------- //
Route::get('/APReport', 'HomeController@articlesReport')->name('APReport');
Route::get('/APReport/index', 'APReportController@index')->name('APReport');
Route::get('/APReport/byDate', 'APReportController@byDate')->name('APReport.byDate');
Route::get('/APReport/byBank', 'APReportController@byBank')->name('APReport.byBank');
Route::get('/APReport/byCurrency', 'APReportController@byCurrency')->name('APReport.byCurrency');
Route::get('/APReport/byProvider', 'APReportController@byProvider')->name('APReport.byProvider');
// ------------------------------------------------------------------------- //
Route::get('/articleReport', 'HomeController@articlesReport')->name('articleReport');
Route::get('/articleReport/index', 'articleReportController@index')->name('articleReport');
Route::get('/articleReport/byDate', 'articleReportController@byDate')->name('articleReport.byDate');
Route::get('/articleReport/byArticle', 'articleReportController@byArticle')->name('articleReport.byArticle');
Route::get('/articleReport/byLine', 'articleReportController@byLine')->name('articleReport.byLine');
Route::get('/articleReport/bySubline', 'articleReportController@bySubline')->name('articleReport.bySubline');
Route::get('/articleReport/byGroup', 'articleReportController@byGroup')->name('articleReport.byGroup');
Route::get('/articleReport/byOrigin', 'articleReportController@byOrigin')->name('articleReport.byOrigin');
Route::get('/articleReport/byType', 'articleReportController@byType')->name('articleReport.byType');
Route::get('/articleReport/byProvider', 'articleReportController@byProvider')->name('articleReport.byProvider');
Route::get('/articleReport/byStatus', 'articleReportController@byStatus')->name('articleReport.byStatus');
// ------------------------------------------------------------------------- //
Route::get('/invoiceReport', 'HomeController@invoiceReport')->name('invoiceReport');
Route::get('/invoiceReport/index', 'invoiceReportController@index')->name('invoiceReport');
Route::get('/invoiceReport/byDate', 'invoiceReportController@byDate')->name('invoiceReport.byDate');
Route::get('/invoiceReport/byUser', 'invoiceReportController@byUser')->name('invoiceReport.byUser');
Route::get('/invoiceReport/byProvider', 'invoiceReportController@byProvider')->name('invoiceReport.byProvider');
Route::get('/invoiceReport/byCancel', 'invoiceReportController@byCancel')->name('invoiceReport.byCancel');
// ------------------------------------------------------------------------- //
Route::get('/recNoteReport', 'HomeController@recNoteReport')->name('recNoteReport');
Route::get('/recNoteReport/index', 'recNoteReportController@index')->name('recNoteReport');
Route::get('/recNoteReport/byDate', 'recNoteReportController@byDate')->name('recNoteReport.byDate');
Route::get('/recNoteReport/byUser', 'recNoteReportController@byUser')->name('recNoteReport.byUser');
Route::get('/recNoteReport/byProvider', 'recNoteReportController@byProvider')->name('recNoteReport.byProvider');
Route::get('/recNoteReport/byCancel', 'recNoteReportController@byCancel')->name('recNoteReport.byCancel');
// ------------------------------------------------------------------------- //
Route::get('/POReport', 'HomeController@POReport')->name('POReport');
Route::get('/POReport/index', 'POReportController@index')->name('POReport');
Route::get('/POReport/byDate', 'POReportController@byDate')->name('POReport.byDate');
Route::get('/POReport/byUser', 'POReportController@byUser')->name('POReport.byUser');
Route::get('/POReport/byProvider', 'POReportController@byProvider')->name('POReport.byProvider');
Route::get('/POReport/byCancel', 'POReportController@byCancel')->name('POReport.byCancel');
// ------------------------------------------------------------------------- //
Route::get('/billReport', 'HomeController@billReport')->name('billReport');
Route::get('/billReport/index', 'billReportController@index')->name('billReport');
Route::get('/billReport/byDate', 'billReportController@byDate')->name('billReport.byDate');
Route::get('/billReport/byUser', 'billReportController@byUser')->name('billReport.byUser');
Route::get('/billReport/byCustomer', 'billReportController@byCustomer')->name('billReport.byCustomer');
Route::get('/billReport/byCancel', 'billReportController@byCancel')->name('billReport.byCancel');
// ------------------------------------------------------------------------- //
Route::get('/delNoteReport', 'HomeController@delNoteReport')->name('delNoteReport');
Route::get('/delNoteReport/index', 'delNoteReportController@index')->name('delNoteReport');
Route::get('/delNoteReport/byDate', 'delNoteReportController@byDate')->name('delNoteReport.byDate');
Route::get('/delNoteReport/byUser', 'delNoteReportController@byUser')->name('delNoteReport.byUser');
Route::get('/delNoteReport/byCustomer', 'delNoteReportController@byCustomer')->name('delNoteReport.byCustomer');
Route::get('/delNoteReport/byCancel', 'delNoteReportController@byCancel')->name('delNoteReport.byCancel');
// ------------------------------------------------------------------------- //
Route::get('/SOReport', 'HomeController@SOReport')->name('SOReport');
Route::get('/SOReport/index', 'SOReportController@index')->name('SOReport');
Route::get('/SOReport/byDate', 'SOReportController@byDate')->name('SOReport.byDate');
Route::get('/SOReport/byUser', 'SOReportController@byUser')->name('SOReport.byUser');
Route::get('/SOReport/byCustomer', 'SOReportController@byCustomer')->name('SOReport.byCustomer');
Route::get('/SOReport/byCancel', 'SOReportController@byCancel')->name('SOReport.byCancel');
// ------------------------------------------------------------------------- //
Route::get('/quoReport', 'HomeController@quoReport')->name('quoReport');
Route::get('/quoReport/index', 'quoReportController@index')->name('quoReport');
Route::get('/quoReport/byDate', 'quoReportController@byDate')->name('quoReport.byDate');
Route::get('/quoReport/byUser', 'quoReportController@byUser')->name('quoReport.byUser');
Route::get('/quoReport/byCustomer', 'quoReportController@byCustomer')->name('quoReport.byCustomer');
Route::get('/quoReport/byCancel', 'quoReportController@byCancel')->name('quoReport.byCancel');
// ------------------------------------------------------------------------- //
Route::get('/empReport', 'HomeController@empReport')->name('empReport');
Route::get('/empReport/index', 'empReportController@index')->name('empReport');
Route::get('/empReport/byDepartment', 'empReportController@byDepartment')->name('empReport.byDepartment');
Route::get('/empReport/byJob', 'empReportController@byJob')->name('empReport.byJob');
Route::get('/empReport/byStatus', 'empReportController@byStatus')->name('empReport.byStatus');
// ------------------------------------------------------------------------- //
Route::get('/hmReport', 'HomeController@hmReport')->name('hmReport');
Route::get('/hmReport/index', 'hmReportController@index')->name('hmReport');
Route::get('/hmReport/byUser', 'hmReportController@byUser')->name('hmReport.byUser');
Route::get('/hmReport/byProject', 'hmReportController@byProject')->name('hmReport.byProject');
Route::get('/hmReport/byGraphic', 'hmReportController@byGraphic')->name('hmReport.byGraphic');
// ------------------------------------------------------------------------- //
Route::get('/managementMaintenance', 'HomeController@managementMaintenance')->name('managementMaintenance');
Route::get('/managementMaintenance/index', 'ManagementMaintenanceController@index')->name('managementMaintenance');
Route::post('/managementMaintenance/checkDepartment', 'ManagementMaintenanceController@checkDepartment')->name('managementMaintenance.checkDepartment');
Route::post('/managementMaintenance/checkJob', 'ManagementMaintenanceController@checkJob')->name('managementMaintenance.checkJob');
Route::post('/managementMaintenance/checkProject', 'ManagementMaintenanceController@checkProject')->name('managementMaintenance.checkProject');
Route::post('/managementMaintenance/checkActivity', 'ManagementMaintenanceController@checkActivity')->name('managementMaintenance.checkActivity');
// ------------------------------------------------------------------------- //
Route::get('/employees', 'HomeController@employees')->name('employees');
Route::get('/employees/index', 'EmployeesController@index')->name('employees');
Route::post('/employees/store', 'EmployeesController@store')->name('employees.store');
Route::get('/employees/additionalInfo', 'EmployeesController@additionalInfo')->name('employees.additionalInfo');
Route::post('/employees/updateUser', 'EmployeesController@updateUser')->name('employees.updateUser');
Route::post('/employees/desactiveEmployee', 'EmployeesController@desactiveEmployee')->name('employees.desactiveEmployee');
// ------------------------------------------------------------------------- //
Route::get('/hoursManagement', 'HomeController@hoursManagement')->name('hoursManagement');
Route::get('/hoursManagement/index', 'HoursManagementController@index')->name('hoursManagement');

Route::post('/hoursManagement/addHours', 'HoursManagementController@addHours')->name('hoursManagement.addHours');
Route::get('/hoursManagement/loadHours', 'HoursManagementController@loadHours')->name('hoursManagement.loadHours');
Route::post('/hoursManagement/deleteHours', 'HoursManagementController@deleteHours')->name('hoursManagement.deleteHours');
Route::get('/hoursManagement/getDateToCode', 'HoursManagementController@getDateToCode')->name('hoursManagement.getDateToCode');
Route::post('/hoursManagement/createCodeHourMgmt', 'HoursManagementController@createCodeHourMgmt')->name('hoursManagement.createCodeHourMgmt');
Route::post('/hoursManagement/updateValidated', 'HoursManagementController@updateValidated')->name('hoursManagement.updateValidated');
Route::get('/hoursManagement/searchToValidated', 'HoursManagementController@searchToValidated')->name('hoursManagement.searchToValidated');
Route::get('/hoursManagement/getHours', 'HoursManagementController@getHours')->name('hoursManagement.getHours');
Route::post('/hoursManagement/saveToValidated', 'HoursManagementController@saveToValidated')->name('hoursManagement.saveToValidated');

// ------------------------------------------------------------------------- //
Route::get('/financeMaintenance', 'HomeController@financeMaintenance')->name('financeMaintenance');
Route::get('/financeMaintenance/index', 'FinanceMaintenanceController@index')->name('financeMaintenance');
Route::post('/financeMaintenance/checkBank', 'FinanceMaintenanceController@checkBank')->name('financeMaintenance.checkBank');
Route::post('/financeMaintenance/checkCurrency', 'FinanceMaintenanceController@checkCurrency')->name('financeMaintenance.checkCurrency');
Route::post('/financeMaintenance/checkPayment', 'FinanceMaintenanceController@checkPayment')->name('financeMaintenance.checkPayment');
// ------------------------------------------------------------------------- //
Route::get('/AR', 'HomeController@AR')->name('AR');
Route::get('/AR/index', 'ARController@index')->name('AR');
Route::post('/AR/saveAR', 'ARController@saveAR')->name('AR.saveAR');
// ------------------------------------------------------------------------- //
Route::get('/AP', 'HomeController@AP')->name('AP');
Route::get('/AP/index', 'APController@index')->name('AP');
Route::post('/AP/saveAP', 'APController@saveAP')->name('AP.saveAP');
// ------------------------------------------------------------------------- //
Route::get('/bill', 'HomeController@bill')->name('bill');
Route::get('/bill/index', 'BillController@index')->name('bill');
Route::get('/bill/selectDeliveryNote', 'BillController@selectDeliveryNote')->name('bill.selectDeliveryNote');
Route::get('/bill/loadArticles', 'BillController@loadArticles')->name('bill.loadArticles');
Route::post('/bill/saveBill', 'BillController@saveBill')->name('bill.saveBill');
Route::get('/bill/print', 'BillController@print')->name('bill.print');
// ------------------------------------------------------------------------- //
Route::get('/deliveryNote', 'HomeController@deliveryNote')->name('deliveryNote');
Route::get('/deliveryNote/index', 'DeliveryNoteController@index')->name('deliveryNote');
Route::get('/deliveryNote/selectSaleOrder', 'DeliveryNoteController@selectSaleOrder')->name('deliveryNote.selectSaleOrder');
Route::get('/deliveryNote/loadArticles', 'DeliveryNoteController@loadArticles')->name('deliveryNote.loadArticles');
Route::post('/deliveryNote/confirmStock', 'DeliveryNoteController@confirmStock')->name('deliveryNote.confirmStock');
Route::post('/deliveryNote/cancelStock', 'DeliveryNoteController@cancelStock')->name('deliveryNote.cancelStock');
Route::post('/deliveryNote/saveDeliveryNote', 'DeliveryNoteController@saveDeliveryNote')->name('deliveryNote.saveDeliveryNote');
Route::get('/deliveryNote/print', 'DeliveryNoteController@print')->name('deliveryNote.print');
Route::get('/deliveryNote/deleteOnUnload', 'DeliveryNoteController@deleteOnUnload')->name('deliveryNote.deleteOnUnload');
// ------------------------------------------------------------------------- //
Route::get('/saleOrder', 'HomeController@saleOrder')->name('saleOrder');
Route::get('/saleOrder/index', 'SaleController@index')->name('saleOrder');
Route::get('/saleOrder/selectQuotation', 'SaleController@selectQuotation')->name('saleOrder.selectQuotation');
Route::get('/saleOrder/loadArticles', 'SaleController@loadArticles')->name('saleOrder.loadArticles');
Route::post('/saleOrder/confirmStock', 'SaleController@confirmStock')->name('saleOrder.confirmStock');
Route::post('/saleOrder/deleteDetail', 'SaleController@deleteDetail')->name('saleOrder.deleteDetail');
Route::post('/saleOrder/deleteQuotation', 'SaleController@deleteQuotation')->name('saleOrder.deleteQuotation');
Route::post('/saleOrder/saveSaleOrder', 'SaleController@saveSaleOrder')->name('saleOrder.saveSaleOrder');
Route::get('/saleOrder/print', 'SaleController@print')->name('saleOrder.print');
Route::get('/saleOrder/deleteOnUnload', 'SaleController@deleteOnUnload')->name('saleOrder.deleteOnUnload');
// ------------------------------------------------------------------------- //
Route::get('/quotation', 'HomeController@quotation')->name('quotation');
Route::get('/quotation/index', 'QuotationController@index')->name('quotation');
Route::get('/quotation/findDetail', 'QuotationController@findDetail')->name('quotation.findDetail');
Route::post('/quotation/cancelDetail', 'QuotationController@cancelDetail')->name('quotation.cancelDetail');
Route::post('/quotation/checkCustomer', 'QuotationController@checkCustomer')->name('quotation.checkCustomer');
Route::post('/quotation/selectArticle', 'QuotationController@selectArticle')->name('quotation.selectArticle');
Route::post('/quotation/addArticle', 'QuotationController@addArticle')->name('quotation.addArticle');
Route::post('/quotation/deleteArticle', 'QuotationController@deleteArticle')->name('quotation.deleteArticle');
Route::post('/quotation/store', 'QuotationController@store')->name('quotation.store');
Route::get('/quotation/print', 'QuotationController@print')->name('quotation.print');
Route::get('/quotation/deleteOnUnload', 'QuotationController@deleteOnUnload')->name('quotation.deleteOnUnload');
Route::get('/quotation/findArticle', 'QuotationController@findArticle')->name('quotation.findArticle');
// ------------------------------------------------------------------------- //
Route::get('/invoice', 'HomeController@invoice')->name('invoice');
Route::get('/invoice/index', 'InvoiceController@index')->name('invoice');
Route::get('/invoice/selectReceiptNote', 'InvoiceController@selectReceiptNote')->name('invoice.selectReceiptNote');
Route::get('/invoice/loadArticles', 'InvoiceController@loadArticles')->name('invoice.loadArticles');
Route::post('/invoice/saveInvoice', 'InvoiceController@saveInvoice')->name('invoice.saveInvoice');
Route::get('/invoice/print', 'InvoiceController@print')->name('invoice.print');
// ------------------------------------------------------------------------- //
Route::get('/receiptNote', 'HomeController@receiptNote')->name('receiptNote');
Route::get('/receiptNote/index', 'ReceiptNoteController@index')->name('receiptNote');
Route::get('/receiptNote/selectPurchaseOrder', 'ReceiptNoteController@selectPurchaseOrder')->name('receiptNote.selectPurchaseOrder');
Route::get('/receiptNote/loadArticles', 'ReceiptNoteController@loadArticles')->name('receiptNote.loadArticles');
Route::post('/receiptNote/confirmStock', 'ReceiptNoteController@confirmStock')->name('receiptNote.confirmStock');
Route::post('/receiptNote/cancelStock', 'ReceiptNoteController@cancelStock')->name('receiptNote.cancelStock');
Route::post('/receiptNote/saveReceiptNote', 'ReceiptNoteController@saveReceiptNote')->name('receiptNote.saveReceiptNote');
Route::get('/receiptNote/print', 'ReceiptNoteController@print')->name('receiptNote.print');
Route::get('/receiptNote/deleteOnUnload', 'ReceiptNoteController@deleteOnUnload')->name('receiptNote.deleteOnUnload');
// ------------------------------------------------------------------------- //
Route::get('/purchaseOrder', 'HomeController@purchaseOrder')->name('purchaseOrder');
Route::get('/purchaseOrder/index', 'PurchaseController@index')->name('purchaseOrder');
Route::get('/purchaseOrder/findDetail', 'PurchaseController@findDetail')->name('purchaseOrder.findDetail');
Route::post('/purchaseOrder/cancelDetail', 'PurchaseController@cancelDetail')->name('purchaseOrder.cancelDetail');
Route::post('/purchaseOrder/checkProvider', 'PurchaseController@checkProvider')->name('purchaseOrder.checkProvider');
Route::post('/purchaseOrder/selectArticle', 'PurchaseController@selectArticle')->name('purchaseOrder.selectArticle');
Route::post('/purchaseOrder/addArticle', 'PurchaseController@addArticle')->name('purchaseOrder.addArticle');
Route::post('/purchaseOrder/deleteArticle', 'PurchaseController@deleteArticle')->name('purchaseOrder.deleteArticle');
Route::post('/purchaseOrder/store', 'PurchaseController@store')->name('purchaseOrder.store');
Route::get('/purchaseOrder/print', 'PurchaseController@print')->name('purchaseOrder.print');
Route::get('/purchaseOrder/deleteOnUnload', 'PurchaseController@deleteOnUnload')->name('purchaseOrder.deleteOnUnload');
// ------------------------------------------------------------------------- //
Route::get('/articles', 'HomeController@articles')->name('articles');
Route::get('/articles/index', 'ArticlesController@index')->name('articles');
Route::post('/articles/store', 'ArticlesController@store')->name('articles.store');
Route::get('/articles/additionalQuery', 'ArticlesController@additionalQuery')->name('articles.additionalQuery');
Route::post('/articles/desactiveArticle', 'ArticlesController@desactiveArticle')->name('articles.desactiveArticle');
// ------------------------------------------------------------------------- //


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
