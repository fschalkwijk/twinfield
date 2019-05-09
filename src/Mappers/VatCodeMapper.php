<?php
namespace PhpTwinfield\Mappers;

use PhpTwinfield\Response\Response;
use PhpTwinfield\VatCode;
use PhpTwinfield\VatCodeAccount;
use PhpTwinfield\VatCodePercentage;

/**
 * Maps a response DOMDocument to the corresponding entity.
 *
 * @package PhpTwinfield
 * @subpackage Mapper
 * @author Yannick Aerssens <y.r.aerssens@gmail.com>
 */
class VatCodeMapper extends BaseMapper
{
    /**
     * Maps a Response object to a clean VatCode entity.
     *
     * @access public
     *
     * @param \PhpTwinfield\Response\Response $response
     *
     * @return VatCode
     * @throws \PhpTwinfield\Exception
     */
    public static function map(Response $response)
    {
        // Generate new VatCode object
        $vatCode = new VatCode();

        // Gets the raw DOMDocument response.
        $responseDOM = $response->getResponseDocument();

        // Get the root/vat element
        $vatCodeElement = $responseDOM->documentElement;

        // Set the result and status attribute
        $vatCode->setResult($vatCodeElement->getAttribute('result'))
            ->setStatus(self::parseEnumAttribute('Status', $vatCodeElement->getAttribute('status')));

        // Set the vat code elements from the vat element
        $vatCode->setCode(self::getField($vatCode, $vatCodeElement, 'code'))
            ->setCreated(self::parseDateTimeAttribute(self::getField($vatCode, $vatCodeElement, 'created')))
            ->setModified(self::parseDateTimeAttribute(self::getField($vatCode, $vatCodeElement, 'modified')))
            ->setName(self::getField($vatCode, $vatCodeElement, 'name'))
            ->setShortName(self::getField($vatCode, $vatCodeElement, 'shortname'))
            ->setTouched(self::getField($vatCode, $vatCodeElement, 'touched'))
            ->setType(self::parseEnumAttribute('VatType', self::getField($vatCode, $vatCodeElement, 'type')))
            ->setUID(self::getField($vatCode, $vatCodeElement, 'uid'))
            ->setUser(self::parseObjectAttribute('User', $vatCode, $vatCodeElement, 'user', array('name' => 'setName', 'shortname' => 'setShortName')));

        // Get the percentages element
        $percentagesDOMTag = $responseDOM->getElementsByTagName('percentages');

        if (isset($percentagesDOMTag) && $percentagesDOMTag->length > 0) {
            // Loop through each returned percentage for the vatcode
            foreach ($percentagesDOMTag->item(0)->childNodes as $percentageElement) {
                if ($percentageElement->nodeType !== 1) {
                    continue;
                }

                // Make a new temporary VatCodePercentage class
                $vatCodePercentage = new VatCodePercentage();

                 // Set the vat code percentage elements from the percentage element
                $vatCodePercentage->setCreated(self::parseDateTimeAttribute(self::getField($vatCodePercentage, $percentageElement, 'created')))
                    ->setDate(self::parseDateAttribute(self::getField($vatCodePercentage, $percentageElement, 'date')))
                    ->setName(self::getField($vatCodePercentage, $percentageElement, 'name'))
                    ->setPercentage(self::getField($vatCodePercentage, $percentageElement, 'percentage'))
                    ->setShortName(self::getField($vatCodePercentage, $percentageElement, 'shortname'))
                    ->setUser(self::parseObjectAttribute('User', $vatCodePercentage, $percentageElement, 'user', array('name' => 'setName', 'shortname' => 'setShortName')));

                // Get the accounts element
                $accountsDOMTag = $percentageElement->getElementsByTagName('accounts');

                if (isset($accountsDOMTag) && $accountsDOMTag->length > 0) {
                    // Loop through each returned account for the percentage
                    foreach ($accountsDOMTag->item(0)->childNodes as $accountElement) {
                        if ($accountElement->nodeType !== 1) {
                            continue;
                        }

                        // Make a new temporary VatCodeAccount class
                        $vatCodeAccount = new VatCodeAccount();

                        // Set the ID attribute
                        $vatCodeAccount->setID($accountElement->getAttribute('id'));

                        // Set the vat code percentage account elements from the account element
                        $vatCodeAccount->setDim1(self::parseObjectAttribute('GeneralLedger', $vatCodeAccount, $accountElement, 'dim1', array('name' => 'setName', 'shortname' => 'setShortName', 'dimensiontype' => 'setTypeFromCode')))
                            ->setGroup(self::parseObjectAttribute('VatGroup', $vatCodeAccount, $accountElement, 'group', array('name' => 'setName', 'shortname' => 'setShortName')))
                            ->setGroupCountry(self::parseObjectAttribute('Country', $vatCodeAccount, $accountElement, 'groupcountry', array('name' => 'setName', 'shortname' => 'setShortName')))
                            ->setLineType(self::parseEnumAttribute('LineType', self::getField($vatCodeAccount, $accountElement, 'linetype')))
                            ->setPercentage(self::getField($vatCodeAccount, $accountElement, 'percentage'));

                        // Add the account to the percentage
                        $vatCodePercentage->addAccount($vatCodeAccount);

                        // Clean that memory!
                        unset ($vatCodeAccount);
                    }
                }

                // Add the percentage to the vat code
                $vatCode->addPercentage($vatCodePercentage);

                // Clean that memory!
                unset ($vatCodePercentage);
            }
        }

        // Return the complete object
        return $vatCode;
    }
}