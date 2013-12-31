<?php
/**
 * This file is part of Swedish-Technical-Bureaucracy.
 *
 * Copyright (c) 2012-14 Hannes Forsgård
 *
 * Swedish-Technical-Bureaucracy is free software: you can redistribute it
 * and/or modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation, either version 3 of the License,
 * or (at your option) any later version.
 *
 * Swedish-Technical-Bureaucracy is distributed in the hope that it will be
 * useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General
 * Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with Swedish-Technical-Bureaucracy.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace iio\stb\Billing;

use DateTime;
use DateInterval;
use iio\stb\Utils\Amount;

/**
 * Generic invoice container object
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class Invoice
{
    /**
     * @var string Invoice serial number
     */
    private $serial;

    /**
     * @var OCR Payment reference number
     */
    private $ocr;

    /**
     * @var DateTime Invoice creation date
     */
    private $billDate;

    /**
     * @var int Number of days before invoice expires
     */
    private $paymentTerm;

    /**
     * @var LegalPerson Seller
     */
    private $seller;

    /**
     * @var LegalPerson Buyer
     */
    private $buyer;

    /**
     * @var Amount Deduction of total cost
     */
    private $deduction;

    /**
     * @var string Message to buyer
     */
    private $message;

    /**
     * @var array Collection of InvoicePost objects
     */
    private $posts = array();

    /**
     * @var string 3-letter ISO 4217 currency code indicating the currency to use
     */
    private $currency = 'SEK';

    /**
     * @var Amount Accumulated invoice VAT
     */
    private $vatTotal;

    /**
     * @var Amount Accumulated invoice unit cost
     */
    private $unitTotal;

    /**
     * @var array Array of InvoicePost objects of VAT rates used in invoice
     */
    private $vatRates = array();

    /**
     * Construct invoice
     *
     * @param string      $serial      Invoice serial number
     * @param LegalPerson $seller
     * @param LegalPerson $buyer
     * @param DateTime    $billDate    Date of invoice creation
     * @param OCR         $ocr         Payment reference number
     * @param array       $posts       Array of InvoicePost objects
     * @param string      $message     Invoice message
     * @param integer     $paymentTerm Nr of days before invoice expires
     * @param Amount      $deduction   Prepaid amound to deduct
     * @param string      $currency    3-letter ISO 4217 currency code indicating the currency to use
     */
    public function __construct(
        $serial,
        LegalPerson $seller,
        LegalPerson $buyer,
        DateTime $billDate,
        OCR $ocr,
        array $posts,
        $message = '',
        $paymentTerm = 30,
        Amount $deduction = null,
        $currency = 'SEK'
    ) {
        $this->serial = (string)$serial;
        $this->seller = $seller;
        $this->buyer = $buyer;
        $this->billDate = $billDate;
        $this->ocr = $ocr;

        $this->vatTotal = new Amount('0');
        $this->unitTotal = new AMount('0');

        foreach ($posts as $post) {
            $this->addPost($post);
        }

        $this->message = (string)$message;
        $this->paymentTerm = (int)$paymentTerm;
        $this->deduction = $deduction ?: new Amount('0');
        $this->currency = (string)$currency;
    }

    /**
     * Get invoice serial number
     *
     * @return string
     */
    public function getSerial()
    {
        return $this->serial;
    }

    /**
     * Get seller
     *
     * @return LegalPerson
     */
    public function getSeller()
    {
        return $this->seller;
    }

    /**
     * Get buyer
     *
     * @return LegalPerson
     */
    public function getBuyer()
    {
        return $this->buyer;
    }

    /**
     * Get date of invoice creation
     *
     * @return DateTime
     */
    public function getBillDate()
    {
        return $this->billDate;
    }

    /**
     * Get invoice reference number
     *
     * @return OCR
     */
    public function getOCR()
    {
        return $this->ocr;
    }

    /**
     * Get invoice message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Get number of days before invoice expires
     *
     * @return int Number of days
     */
    public function getPaymentTerm()
    {
        return $this->paymentTerm;
    }

    /**
     * Get date when invoice expires
     *
     * @return DateTime
     */
    public function getExpirationDate()
    {
        $expireDate = clone $this->billDate;
        $expireDate->add(new DateInterval("P{$this->getPaymentTerm()}D"));

        return $expireDate;
    }

    /**
     * Get deduction (amount prepaid)
     *
     * @return Amount
     */
    public function getDeduction()
    {
        return $this->deduction;
    }

    /**
     * Get the 3-letter ISO 4217 currency code indicating the invoice currency
     *
     * @return string Currency code
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Get list of registered posts
     *
     * @return array
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * Get total VAT amount
     *
     * @return Amount
     */
    public function getVatTotal()
    {
        return $this->vatTotal;
    }

    /**
     * Get total unit amount (VAT excluded)
     *
     * @return Amount
     */
    public function getUnitTotal()
    {
        return $this->unitTotal;
    }

    /**
     * Get charged amount (VAT included)
     *
     * @return Amount
     */
    public function getInvoiceTotal()
    {
        return $this->getVatTotal()
            ->add($this->getUnitTotal())
            ->subtract($this->getDeduction());
    }

    /**
     * Get summations for vat rates used in invoice
     *
     * @return array Array of InvoicePost objects
     */
    public function getVatRates()
    {
        ksort($this->vatRates);
        return array_values($this->vatRates);
    }


    /**
     * Add post to invoice
     *
     * @param  InvoicePost $post
     * @return void
     */
    private function addPost(InvoicePost $post)
    {
        $this->posts[] = $post;

        // Cache VAT and unit totals
        $this->vatTotal->add($post->getVatTotal());
        $this->unitTotal->add($post->getUnitTotal());

        // Cache used VAT rates
        if ($post->getVatRate()->hasValue()) {
            $key = (string)$post->getVatRate();

            if (!array_key_exists($key, $this->vatRates)) {
                $this->vatRates[$key] = new InvoicePost(
                    '',
                    new Amount('1'),
                    new Amount('0'),
                    $post->getVatRate()
                );
            }

            $this->vatRates[$key]->getUnitCost()->add($post->getUnitTotal());
        }
    }
}
