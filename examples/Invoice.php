<?php

/* Invoice
 * Twinfield UI:            https://accounting.twinfield.com/UI/#/Sales/ClassicInvoices
 * API Documentation:       https://c3.twinfield.com/webservices/documentation/#/ApiReference/SalesInvoices
 */

//Optionally declare the namespace PhpTwinfield so u can call classes without prepending \PhpTwinfield\
namespace PhpTwinfield;

// Use the ResponseException class to handle errors when listing, getting and sending objects to/from Twinfield
use PhpTwinfield\Response\ResponseException;

require_once('vendor/autoload.php');

// Retrieve an OAuth 2 connection
require_once('Connection.php');

/* Invoice API Connector
 * \PhpTwinfield\ApiConnectors\InvoiceApiConnector
 * Available methods: get, listAll, send, sendAll
 */

// Run all or only some of the following examples
$executeListAllWithFilter           = false;
$executeListAllWithoutFilter        = true;
$executeRead                        = true;
$executeCopy                        = false;
$executeNew                         = false;

$invoiceApiConnector = new \PhpTwinfield\ApiConnectors\InvoiceApiConnector($connection);

// Office code
$officeCode = "SomeOfficeCode";

// Create a new Office object from the $officeCode
$office = \PhpTwinfield\Office::fromCode($officeCode);

/* List all invoices
 * @param string $pattern  The search pattern. May contain wildcards * and ?
 * @param int    $field    The search field determines which field or fields will be searched. The available fields
 *                         depends on the finder type. Passing a value outside the specified values will cause an
 *                         error. 0 Searches for the dimension code or dimension name, outstanding invoice amount, invoice number
 *                         1 searches only on the code field, 2 searches only on the name field
 * @param int    $firstRow First row to return, useful for paging
 * @param int    $maxRows  Maximum number of rows to return, useful for paging
 * @param array  $options  The Finder options. Passing an unsupported name or value causes an error. It's possible
 *                         to add multiple options. An option name may be used once, specifying an option multiple
 *                         times will cause an error.
 *
 *                         Available options:      office, dim1 - dim6, value, openvalue
 *
 *                         office                  Sets the office code.
 *                         Usage:                  $options['office'] = 'SomeOfficeCode';
 *
 *                         dim1 - dim6             Specifies a dimension code (and in such a financial level).
 *                         Usage:                  $options['dim1'] = '1010';
 *
 *                         value                   Specifies the (original invoice) value.
 *                         Usage:                  $options['value'] = '100.50';
 *
 *                         openvalue               Specifies the open value.
 *                         Usage:                  $options['openvalue'] = '50.25';
 *
 */

//List all with pattern "2019*", field 0 (= search code or name), firstRow 1, maxRows 10, options -> openvalue = 50.25
if ($executeListAllWithFilter) {
    $options = array('openvalue' => 50.25);

    try {
        $invoices = $invoiceApiConnector->listAll("2019*", 0, 1, 10, $options);
    } catch (ResponseException $e) {
        $invoices = $e->getReturnedObject();
    }

    echo "<pre>";
    print_r($invoices);
    echo "</pre>";
}

//List all with default settings (pattern '*', field 0, firstRow 1, maxRows 100, options [])
if ($executeListAllWithoutFilter) {
    try {
        $invoices = $invoiceApiConnector->listAll();
    } catch (ResponseException $e) {
        $invoices = $e->getReturnedObject();
    }

    echo "<pre>";
    print_r($invoices);
    echo "</pre>";
}

/* Invoice
 * \PhpTwinfield\Invoice
 * Available getters: getBank, getBankToString, getCalculateOnly, getCalculateOnlyToString, getCurrency, getCurrencyToString, getCustomer, getCustomerName, getCustomerToString, getDebitCredit, getDeliverAddressNumber, getDueDate, getDueDateToString, getFinancialCode, getFinancialNumber,
 * getFooterText, getHeaderText, getInvoiceAddressNumber, getInvoiceAmount, getInvoiceAmountToFloat, getInvoiceDate, getInvoiceDateToString, getInvoiceNumber, getInvoiceType, getInvoiceTypeToString, getMessages, getOffice, getOfficeToString, getPaymentMethod,
 * getPerformanceDate, getPerformanceDateToString, getPeriod, getPeriodRaiseWarning, getPeriodRaiseWarningToString, getRaiseWarning, getRaiseWarningToString, getResult, getStatus, hasMessages, getLines, getMatchReference, getTotals, getVatLines
 *
 * Available setters: setBank, setBankFromString, setCalculateOnly, setCalculateOnlyFromString, setCurrency, setCurrencyFromString, setCustomer, setCustomerFromString, setCustomerName, setDebitCredit, setDebitCreditFromString, setDeliverAddressNumber, setDueDate, setDueDateFromString,
 * setFinancialCode, setFinancialNumber, setFooterText, setHeaderText, setInvoiceAddressNumber, setInvoiceAmount, setInvoiceAmountFromFloat, setInvoiceDate, setInvoiceDateFromString, setInvoiceNumber, setInvoiceType, setInvoiceTypeFromString, setOffice,
 * setOfficeFromString, setPaymentMethod, setPaymentMethodFromString, setPerformanceDate, setPerformanceDateFromString, setPeriod, setPeriodRaiseWarning, setPeriodRaiseWarningFromString, setRaiseWarning, setRaiseWarningFromString, setStatus, setStatusFromString, setTotals, addLine, addVatLine, removeLine, removeVatLine
 *
 */

/* InvoiceTotals
 * \PhpTwinfield\InvoiceTotals
 * Available getters: getMessages, getResult, getValueExcl, getValueExclToFloat, getValueInc, getValueIncToFloat, hasMessages
 * Available setters: setValueExcl, setValueExclFromFloat, setValueInc, setValueIncFromFloat
 */

/* InvoiceLine
 * \PhpTwinfield\InvoiceLine
 * Available getters: getAllowDiscountOrPremium, getAllowDiscountOrPremiumToString, getArticle, getArticleToString, getDescription, getDim1, getDim1ToString, getFreetext1, getFreetext2, getFreetext3, getID, getMessages, getPerformanceDate, getPerformanceDateToString, getPerformanceType,
 * getQuantity, getResult, getSubArticle, getSubArticleToString, getUnits, getUnitsPriceExcl, getUnitsPriceExclToFloat, getUnitsPriceInc, getUnitsPriceIncToFloat, getValueExcl, getValueExclToFloat, getValueInc, getValueIncToFloat, getVatCode, getVatCodeToString, getVatValue, getVatValueToFloat, hasMessages
 * Available setters: setAllowDiscountOrPremium, setAllowDiscountOrPremiumFromString, setArticle, setArticleFromString, setDescription, setDim1, setDim1FromString, setFreetext1, setFreetext2, setFreetext3, setID, setPerformanceDate, setPerformanceDateFromString, setPerformanceType, setPerformanceTypeFromString,
 * setQuantity, setSubArticle, setSubArticleFromString, setUnits, setUnitsPriceExcl, setUnitsPriceExclFromFloat, setUnitsPriceInc, setUnitsPriceIncFromFloat, setValueExcl, setValueExclFromFloat, setValueInc, setValueIncFromFloat, setVatCode, setVatCodeFromString, setVatValue, setVatValueFromFloat
 */

/* InvoiceVatLine
 * \PhpTwinfield\InvoiceVatLine
 * Available getters: getMessages, getPerformanceDate, getPerformanceDateToString, getPerformanceType, getResult, getVatCode, getVatCodeToString, getVatValue, getVatValueToFloat, hasMessages
 * Available setters: setPerformanceDate, setPerformanceDateFromString, setPerformanceType, setPerformanceTypeFromString, setVatCode, setVatCodeFromString, setVatValue, setVatValueFromFloat
 */

if ($executeListAllWithFilter || $executeListAllWithoutFilter) {
    foreach ($invoices as $key => $invoice) {
        echo "Invoice {$key}<br />";
        echo "InvoiceNumber: {$invoice->getInvoiceNumber()}<br />";
        echo "InvoiceAmount: {$invoice->getInvoiceAmountToFloat()}<br />";
        echo "Customer: {$invoice->getCustomerToString()}<br />";
        echo "CustomerName: {$invoice->getCustomerName()}<br />";
        echo "Debit/Credit: {$invoice->getDebitCredit()}<br /><br />";
    }
}

// Read an Invoice based off the passed in code and optionally the office.
if ($executeRead) {
    try {
        $invoice = $invoiceApiConnector->get("FACTUUR", "1", $office);
    } catch (ResponseException $e) {
        $invoice = $e->getReturnedObject();
    }

    echo "<pre>";
    print_r($invoice);
    echo "</pre>";

    echo "Invoice<br />";
    echo "Bank (\\PhpTwinfield\\CashBankBook): <pre>" . print_r($invoice->getBank(), true) . "</pre><br />";                      					// CashBankBook|null            Bank code.
    echo "Bank (string): {$invoice->getBankToString()}<br />";                                                              					    // string|null
    echo "Currency (\\PhpTwinfield\\Currency): <pre>" . print_r($invoice->getCurrency(), true) . "</pre><br />";                      				// Currency|null                Currency code.
    echo "Currency (string): {$invoice->getCurrencyToString()}<br />";                                                              				// string|null
    echo "Customer (\\PhpTwinfield\\Customer): <pre>" . print_r($invoice->getCustomer(), true) . "</pre><br />";                      				// Customer|null                Customer code.
    echo "Customer (string): {$invoice->getCustomerToString()}<br />";                                                              				// string|null
    echo "DeliverAddressNumber: {$invoice->getDeliverAddressNumber()}<br />";                                                                       // int|null
    echo "DueDate (\\DateTimeInterface): <pre>" . print_r($invoice->getDueDate(), true) . "</pre><br />";                                           // \DateTimeInterface|null      Due date.
    echo "DueDate (string): {$invoice->getDueDateToString()}<br />";                                                                                // string|null
    echo "FinancialCode: {$invoice->getFinancialCode()}<br />";                                                                                     // string|null                  The transaction type code. Read-only attribute.
    echo "FinancialNumber: {$invoice->getFinancialNumber()}<br />";                                                                                 // string|null                  The transaction number. Read-only attribute.
    echo "FooterText: {$invoice->getFooterText()}<br />";                                                                                           // string|null                  Footer text on the invoice.
    echo "HeaderText: {$invoice->getHeaderText()}<br />";                                                                                           // string|null                  Header text on the invoice.
    echo "InvoiceAddressNumber: {$invoice->getInvoiceAddressNumber()}<br />";                                                                       // int|null
    echo "InvoiceDate (\\DateTimeInterface): <pre>" . print_r($invoice->getInvoiceDate(), true) . "</pre><br />";                                   // \DateTimeInterface|null      Invoice date.
    echo "InvoiceDate (string): {$invoice->getInvoiceDateToString()}<br />";                                                                        // string|null
    echo "InvoiceNumber: {$invoice->getInvoiceNumber()}<br />";                                                                                     // string|null                  Invoice Number.
    echo "InvoiceType (\\PhpTwinfield\\InvoiceType): <pre>" . print_r($invoice->getInvoiceType(), true) . "</pre><br />";                      		// InvoiceType|null             Invoice type code.
    echo "InvoiceType (string): {$invoice->getInvoiceTypeToString()}<br />";                                                              			// string|null

    if ($invoice->hasMessages()) {                                                                                              					// bool                         Object contains (error) messages true/false.
        echo "Messages: " . print_r($invoice->getMessages(), true) . "<br />";                                                  					// Array|null                   (Error) messages.
    }

    echo "PaymentMethod: {$invoice->getPaymentMethod()}<br />";                                                             					    // PaymentMethod|null           The payment method.
    echo "PerformanceDate (\\DateTimeInterface): <pre>" . print_r($invoice->getPerformanceDate(), true) . "</pre><br />";                           // \DateTimeInterface|null      Performance date, when set-up on the invoice header.
    echo "PerformanceDate (string): {$invoice->getPerformanceDateToString()}<br />";                                                                // string|null
    echo "Period: {$invoice->getPeriod()}<br />";                                                                                                   // string|null                  Period in YYYY/PP format.
    echo "Office (\\PhpTwinfield\\Office): <pre>" . print_r($invoice->getOffice(), true) . "</pre><br />";                      					// Office|null                  Office code.
    echo "Office (string): {$invoice->getOfficeToString()}<br />";                                                              					// string|null
    echo "Result: {$invoice->getResult()}<br />";                                                                               					// int|null                     Result (0 = error, 1 or empty = success).
    echo "Status: {$invoice->getStatus()}<br />";                                                                               					// Status|null                  Status of the invoice.

    $invoiceTotals = $invoice->getTotals();

    echo "InvoiceTotals<br />";

    if ($invoiceTotals->hasMessages()) {                                                                                              				// bool                         Object contains (error) messages true/false.
        echo "Messages: " . print_r($invoiceTotals->getMessages(), true) . "<br />";                                                  				// Array|null                   (Error) messages.
    }

    echo "Result: {$invoiceTotals->getResult()}<br />";                                                                               				// int|null                     Result (0 = error, 1 or empty = success).
    echo "ValueExcl (\\Money\\Money): <pre>" . print_r($invoiceTotals->getValueExcl(), true) . "</pre><br />";                                      // Money|null                   Value without VAT. Read-only attribute.
    echo "ValueExcl (string): {$invoiceTotals->getValueExclToFloat()}<br />";                                                                       // float|null
    echo "ValueInc (\\Money\\Money): <pre>" . print_r($invoiceTotals->getValueInc(), true) . "</pre><br />";                                        // Money|null                   Value with VAT. Read-only attribute.
    echo "ValueInc (string): {$invoiceTotals->getValueIncToFloat()}<br />";                                                                         // float|null

    if ($invoice->getFinancialCode() != null && $invoice->getFinancialNumber != null) {
        $match = $invoice->getMatchReference();
        echo "Match (\\PhpTwinfield\\MatchReference): <pre>" . print_r($match, true) . "</pre><br />";                      					    // MatchReference|null
    }

    $invoiceLines = $invoice->getLines();                                                                                                           // array|null                   Array of InvoiceLine objects.

    foreach ($invoiceLines as $key => $invoiceLine) {
        echo "InvoiceLine {$key}<br />";

        echo "AllowDiscountOrPremium (bool): {$invoiceLine->getAllowDiscountOrPremium()}<br />";                                                    // bool|null                    Calculate discount on this line.
        echo "AllowDiscountOrPremium (string): {$invoiceLine->getAllowDiscountOrPremiumToString()}<br />";                                          // string|null
        echo "Article (\\PhpTwinfield\\Article): <pre>" . print_r($invoiceLine->getArticle(), true) . "</pre><br />";                      			// Article|null                 Article code.
        echo "Article (string): {$invoiceLine->getArticleToString()}<br />";                                                              			// string|null
        echo "Description: {$invoiceLine->getDescription()}<br />";                                                                                 // string|null                  Invoice line description, only on the lines with article ‘0’ or ‘-‘.
        echo "Dim1 (\\PhpTwinfield\\GeneralLedger): <pre>" . print_r($invoiceLine->getDim1(), true) . "</pre><br />";                               // GeneralLedger|null           Balance account.
        echo "Dim1 (string): {$invoiceLine->getDim1ToString()}<br />";                                                                              // string|null
        echo "FreeText1: {$invoiceLine->getFreetext1()}<br />";                                                                                     // string|null                  Free text field 1 as entered on the invoice type.
        echo "FreeText2: {$invoiceLine->getFreetext2()}<br />";                                                                                     // string|null                  Free text field 2 as entered on the invoice type.
        echo "FreeText3: {$invoiceLine->getFreetext3()}<br />";                                                                                     // string|null                  Free text field 3 as entered on the invoice type.
        echo "ID: {$invoiceLine->getID()}<br />";                                                                                                   // int|null                     Line ID

        if ($invoiceLine->hasMessages()) {                                                                                					        // bool                         Object contains (error) messages true/false.
            echo "Messages: " . print_r($invoiceLine->getMessages(), true) . "<br />";                                    					        // Array|null                   (Error) messages.
        }

        echo "PerformanceDate (\\DateTimeInterface): <pre>" . print_r($invoiceLine->getPerformanceDate(), true) . "</pre><br />";                   // \DateTimeInterface|null      Performance date, when set-up on invoice lines.
        echo "PerformanceDate (string): {$invoiceLine->getPerformanceDateToString()}<br />";                                                        // string|null
        echo "PerformanceType: {$invoiceLine->getPerformanceType()}<br />";                                                                         // PerformanceType|null         The performance type in case of an ICT sales invoice.
        echo "Quantity: {$invoiceLine->getQuantity()}<br />";                                                                               		// int|null                     The quantity on the sales invoice line.
        echo "Result: {$invoiceLine->getResult()}<br />";                                                                                           // int|null                     Result (0 = error, 1 or empty = success).
        echo "SubArticle (\\PhpTwinfield\\ArticleLine): <pre>" . print_r($invoiceLine->getSubArticle(), true) . "</pre><br />";                     // ArticleLine|null             Sub-article code.
        echo "SubArticle (string): {$invoiceLine->getSubArticleToString()}<br />";                                                              	// string|null
        echo "Units: {$invoiceLine->getUnits()}<br />";                                                                               			    // int|null                     The number of units per quantity.
        echo "UnitsPriceExcl (\\Money\\Money): <pre>" . print_r($invoiceLine->getUnitsPriceExcl(), true) . "</pre><br />";                          // Money|null                   Only valid for invoice types with VAT exclusive units prices.
        echo "UnitsPriceExcl (string): {$invoiceLine->getUnitsPriceExclToFloat()}<br />";                                                           // float|null                   Only add this tag to an XML request if the setting Prices can be changed on an item is set to true. Otherwise, the price will be determined by the system.
        echo "UnitsPriceInc (\\Money\\Money): <pre>" . print_r($invoiceLine->getUnitsPriceInc(), true) . "</pre><br />";                            // Money|null                   Only valid for invoice types with VAT inclusive units prices.
        echo "UnitsPriceInc (string): {$invoiceLine->getUnitsPriceIncToFloat()}<br />";                                                             // float|null                   Only add this tag to an XML request if the setting Prices can be changed on an item is set to true. Otherwise, the price will be determined by the system.
        echo "ValueExcl (\\Money\\Money): <pre>" . print_r($invoiceLine->getValueExcl(), true) . "</pre><br />";                                    // Money|null                   Calculated element. Read-only attribute.
        echo "ValueExcl (string): {$invoiceLine->getValueExclToFloat()}<br />";                                                                     // float|null
        echo "ValueInc (\\Money\\Money): <pre>" . print_r($invoiceLine->getValueInc(), true) . "</pre><br />";                                      // Money|null                   Calculated element. Read-only attribute.
        echo "ValueInc (string): {$invoiceLine->getValueIncToFloat()}<br />";                                                                       // float|null
        echo "VatCode (\\PhpTwinfield\\VatCode): <pre>" . print_r($invoiceLine->getVatCode(), true) . "</pre><br />";                      			// VatCode|null                 VAT code.
        echo "VatCode (string): {$invoiceLine->getVatCodeToString()}<br />";                                                              			// string|null
        echo "VatValue (\\Money\\Money): <pre>" . print_r($invoiceLine->getVatValue(), true) . "</pre><br />";                                      // Money|null                   Calculated element. Read-only attribute.
        echo "VatValue (string): {$invoiceLine->getVatValueToFloat()}<br />";                                                                       // float|null
    }

    $invoiceVatLines = $invoice->getVatLines();                                                                                                     // array|null                   Array of InvoiceVatLine objects.

    foreach ($invoiceVatLines as $key => $invoiceVatLine) {
        echo "InvoiceVatLine {$key}<br />";

        if ($invoiceVatLine->hasMessages()) {                                                                                					    // bool                         Object contains (error) messages true/false.
            echo "Messages: " . print_r($invoiceVatLine->getMessages(), true) . "<br />";                                    					    // Array|null                   (Error) messages.
        }

        echo "PerformanceDate (\\DateTimeInterface): <pre>" . print_r($invoiceVatLine->getPerformanceDate(), true) . "</pre><br />";                // \DateTimeInterface|null      The performance date. Only in case performancetype = services. Read-only attribute.
        echo "PerformanceDate (string): {$invoiceVatLine->getPerformanceDateToString()}<br />";                                                     // string|null
        echo "PerformanceType: {$invoiceVatLine->getPerformanceType()}<br />";                                                                      // PerformanceType|null         The performance type. Read-only attribute.
        echo "Result: {$invoiceVatLine->getResult()}<br />";                                                                                        // int|null                     Result (0 = error, 1 or empty = success).
        echo "VatCode (\\PhpTwinfield\\VatCode): <pre>" . print_r($invoiceVatLine->getVatCode(), true) . "</pre><br />";                      		// VatCode|null                 VAT code. Read-only attribute.
        echo "VatCode (string): {$invoiceVatLine->getVatCodeToString()}<br />";                                                              		// string|null
        echo "VatValue (\\Money\\Money): <pre>" . print_r($invoiceVatLine->getVatValue(), true) . "</pre><br />";                                   // Money|null                   VAT amount. Read-only attribute.
        echo "VatValue (string): {$invoiceVatLine->getVatValueToFloat()}<br />";                                                                    // float|null
    }
}

// Copy an existing Invoice to a new entity
if ($executeCopy) {
    try {
        $invoice = $invoiceApiConnector->get("FACTUUR", "1", $office);
    } catch (ResponseException $e) {
        $invoice = $e->getReturnedObject();
    }

    $invoice->setInvoiceNumber(null);

    //Optional, but recommended so your copy is not posted to final immediately
    $invoice->setStatusFromString('concept');

    try {
        $invoiceCopy = $invoiceApiConnector->send($invoice);
    } catch (ResponseException $e) {
        $invoiceCopy = $e->getReturnedObject();
    }

    echo "<pre>";
    print_r($invoiceCopy);
    echo "</pre>";

    echo "Result of copy process: {$invoiceCopy->getResult()}<br />";
    echo "Number of copied Invoice: {$invoiceCopy->getInvoiceNumber()}<br />";
}

// Create a new Invoice from scratch, alternatively read an existing Invoice as shown above and than modify the values in the same way as shown below
if ($executeNew) {
    $invoice = new \PhpTwinfield\Invoice;

    // Required values for creating a new Invoice
    $customer = new \PhpTwinfield\Customer;
    $customer->setCode('1000');
    $invoice->setCustomer($customer);                                                                                                               // Customer|null                Customer code.
    $invoice->setCustomerFromString("1000");                                                                                                        // string|null
    $invoiceType = new \PhpTwinfield\InvoiceType;
    $invoiceType->setCode('FACTUUR');
    $invoice->setInvoiceType($invoiceType);                                                                                                         // InvoiceType|null             Invoice type code.
    $invoice->setInvoiceTypeFromString("FACTUUR");                                                                                                  // string|null
    $invoice->setOffice($office);                                                                                                                   // Office|null                  Office code.
    $invoice->setOfficeFromString($officeCode);                                                                                                     // string|null

    // Optional values for creating a new Invoice
    $invoice->setCalculateOnly(false);                                                                                                              // bool|null                    Attribute to indicate that invoice should not be saved but only checked and calculated. @calculateonly must be true for that.
    $invoice->setCalculateOnlyFromString('false');                                                                                                  // string|null
    $invoice->setRaiseWarning(true);                                                                                                                // bool|null                    Should warnings be given true or not false? Default true.
    $invoice->setRaiseWarningFromString('true');                                                                                                    // string|null
    $bank = new \PhpTwinfield\CashBankBook;
    $bank->setCode('BNK');
    $invoice->setBank($bank);                                                                                                                       // CashBankBook|null            Customer code.
    $invoice->setBankFromString("BNK");
    $currency = new \PhpTwinfield\Currency;
    $currency->setCode('EUR');
    $invoice->setCurrency($currency);                                                                                                               // Currency|null                Currency code.
    $invoice->setCurrencyFromString("EUR");
    $invoice->setDeliverAddressNumber(1);                                                                                                           // int|null                     If you want the default address, omit the tag or leave it empty.
    $dueDate = \DateTime::createFromFormat('d-m-Y', '01-07-2019');
    $invoice->setDueDate($dueDate);                                                                                                                 // \DateTimeInterface|null      Due date.
    $invoice->setDueDateFromString("20190701");                                                                                                     // string|null
    $invoice->setFooterText("Example Footer");                                                                                                      // string|null                  Footer text on the invoice.
    $invoice->setHeaderText("Example Header");                                                                                                      // string|null                  Header text on the invoice.
    $invoice->setInvoiceAddressNumber(1);                                                                                                           // int|null                     If you want the default address, omit the tag or leave it empty.
    $invoiceDate = \DateTime::createFromFormat('d-m-Y', '01-07-2019');
    $invoice->setInvoiceDate($invoiceDate);                                                                                                         // \DateTimeInterface|null      Optional; when the invoicedate is not supplied Twinfield uses the system date as the invoice date.
    $invoice->setInvoiceDateFromString("20190701");                                                                                                 // string|null
    $invoice->setPaymentMethod(\PhpTwinfield\Enums\PaymentMethod::BANK());                                                                          // PaymentMethod|null           The payment method.
    $invoice->setPaymentMethodFromString("bank");                                                                                                   // string|null
    $performanceDate = \DateTime::createFromFormat('d-m-Y', '01-07-2019');
    $invoice->setPerformanceDate($performanceDate);                                                                                                 // \DateTimeInterface|null      Performance date, when set-up on the invoice header.
    $invoice->setPerformanceDateFromString("20190701");                                                                                             // string|null
    $invoice->setPeriod("2019/07");                                                                                                                 // string|null                  Period in YYYY/PP format.
    $invoice->setPeriodRaiseWarning(false);                                                                                                         // bool|null                    Optionally, it is possible to suppress warnings about 'date out of range for the given period' by adding the raisewarning attribute and set its value to false.

    $invoice->setPeriodRaiseWarningFromString('false');                                                                                             // string|null                  This overwrites the value of the raisewarning attribute as set on the root element.
    //$invoice->setStatus(\PhpTwinfield\Enums\InvoiceStatus::CONCEPT());                                                                            // InvoiceStatus|null           default can only be returned when retrieving a sales invoice.
    //$invoice->setStatus(\PhpTwinfield\Enums\InvoiceStatus::FINAL());                                                                              // InvoiceStatus|null           You cannot use this status when creating or updating an invoice.
    //$invoice->setStatusFromString('concept');                                                                                                     // string|null                  concept saves the invoice as provisional. After saving as final, no changes can be made anymore.
    //$invoice->setStatusFromString('final');                                                                                                       // string|null                  When posting an invoice final, a financial transaction is generated and posted automatically.

    // The minimum amount of InvoiceLines linked to an Invoice object is 1
    $invoiceLine = new \PhpTwinfield\InvoiceLine;

    $invoiceLine->setAllowDiscountOrPremium(true);                                                                                                  // bool|null                    Calculate discount on this line.
    $invoiceLine->setAllowDiscountOrPremiumFromString('true');                                                                                      // string|null
    $article = new \PhpTwinfield\Article;
    $article->setCode('9060');
    $invoiceLine->setArticle($article);                      		                                                                                // Article|null                 Article code.
    $invoiceLine->setArticleFromString('9060');                                                       	                                            // string|null
    //$invoiceLine->setDescription('Example Description');                                                       	                                // string|null                  Invoice line description, only on the lines with article ‘0’ or ‘-‘.
    $dim1 = new \PhpTwinfield\GeneralLedger;
    $dim1->setCode('9060');
    $invoiceLine->setDim1($dim1);                      		                                                                                        // GeneralLedger|null           Balance account.
    $invoiceLine->setDim1FromString('9060');                                                       	                                                // string|null
    //$invoiceLine->setFreeText1('Example Free Text 1');                                                       	                                    // string|null                  Free text field 1 as entered on the invoice type.
    //$invoiceLine->setFreeText2('Example Free Text 2');                                                       	                                    // string|null                  Free text field 2 as entered on the invoice type.
    //$invoiceLine->setFreetext3("Example Free Text 3");                                                                                            // string|null                  Free text field 3 as entered on the invoice type.
    $invoiceLine->setID(1);                                                                                                                         // int|null                     Line ID.
    //$invoice->setPerformanceType(\PhpTwinfield\Enums\PerformanceType::SERVICES());                                                                // PerformanceType|null         The performance type in case of an ICT sales invoice.
    //$invoice->setPerformanceTypeFromString("services");                                                                                           // string|null
    //$invoiceLine->setPerformanceDate($performanceDate);                                                                                           // \DateTimeInterface|null      Performance date, when set-up on invoice lines.
    //$invoiceLine->setPerformanceDateFromString("20190701");                                                                                       // string|null
    $invoiceLine->setQuantity(1);                                                                                                                   // int|null                     The quantity on the sales invoice line.
    $subArticle = new \PhpTwinfield\ArticleLine;
    $subArticle->setSubCode('9060');
    $invoiceLine->setSubArticle($subArticle);                      		                                                                            // ArticleLine|null             Sub-article code.
    $invoiceLine->setSubArticleFromString('9060');                                                       	                                        // string|null
    $invoiceLine->setUnits(1);                                                                                                                      // int|null                     The number of units per quantity.
    $invoiceLine->setUnitsPriceExcl(\Money\Money::EUR(1000));                                                                                       // Money|null                   Only valid for invoice types with VAT exclusive units prices. Only add this tag to an XML request if the setting Prices can be changed on an item is set to true.
    $invoiceLine->setUnitsPriceExclFromFloat(10);                                                                                                   // float|null                   Otherwise, the price will be determined by the system.
    //$invoiceLine->setUnitsPriceInc(\Money\Money::EUR(1210));                                                                                      // Money|null                   Only valid for invoice types with VAT inclusive units prices. Only add this tag to an XML request if the setting Prices can be changed on an item is set to true.
    //$invoiceLine->setUnitsPriceIncFromFloat(12.10);                                                                                               // float|null                   Otherwise, the price will be determined by the system.
    $vatCode = new \PhpTwinfield\VatCode;
    $vatCode->setCode('VH');
    //$invoiceLine->getVatCode($vatCode);                                                                                                           // VatCode|null                 VAT code.
    //$invoiceLine->setVatCodeFromString('VH');                                                                                                     // string|null

    $invoice->addLine($invoiceLine);                                                                                                                // InvoiceLine                  Add an InvoiceLine object to the Invoice object
    //$invoice->removeLine(1);                                                                                                                      // int                          Remove an invoice line based on the id of the invoice line

    try {
        $invoiceNew = $invoiceApiConnector->send($invoice);
    } catch (ResponseException $e) {
        $invoiceNew = $e->getReturnedObject();
    }

    echo "<pre>";
    print_r($invoiceNew);
    echo "</pre>";

    echo "Result of creation process: {$invoiceNew->getResult()}<br />";
    echo "Number of new Invoice: {$invoiceNew->getInvoiceNumber()}<br />";
}