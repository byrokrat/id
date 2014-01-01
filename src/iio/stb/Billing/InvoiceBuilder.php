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
use iio\stb\Utils\Amount;
use iio\stb\Exception;

/**
 * Interface for creating Invoices
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class InvoiceBuilder
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
     * @var boolean Flag if OCR may be generated from serial
     */
    private $generateOCR = false;

    /**
     * @var LegalPerson Seller
     */
    private $seller;

    /**
     * @var LegalPerson Buyer
     */
    private $buyer;

    /**
     * @var DateTime Invoice creation date
     */
    private $billDate;

    /**
     * @var int Number of days before invoice expires
     */
    private $paymentTerm = 30;

    /**
     * @var Amount Deduction of total cost
     */
    private $deduction = null;

    /**
     * @var string Message to buyer
     */
    private $message = '';

    /**
     * @var array Collection of InvoicePost objects
     */
    private $posts = array();

    /**
     * @var string 3-letter ISO 4217 currency code indicating the currency to use
     */
    private $currency = 'SEK';

    /**
     * Construct invoice
     *
     * @return Invoice
     */
    public function getInvoice()
    {
        return new Invoice(
            $this->getSerial(),
            $this->getSeller(),
            $this->getBuyer(),
            $this->getBillDate(),
            $this->getOCR(),
            $this->posts,
            $this->message,
            $this->paymentTerm,
            $this->deduction,
            $this->currency
        );
    }

    /**
     * Reset builder values
     *
     * @return InvoiceBuilder Instance for chaining
     */
    public function reset()
    {
        unset($this->serial);
        unset($this->ocr);
        $this->generateOCR = false;
        unset($this->seller);
        unset($this->buyer);
        unset($this->billDate);
        $this->paymentTerm = 30;
        $this->deduction = null;
        $this->message = '';
        $this->posts = array();
        $this->currency = 'SEK';

        return $this;
    }

    /**
     * Set serial
     *
     * @param  string         $serial
     * @return InvoiceBuilder Instance for chaining
     */
    public function setSerial($serial)
    {
        $this->serial = $serial;
        return $this;
    }

    /**
     * Get invoice serial number
     *
     * @return string
     * @throws Exception If serial is not set
     */
    public function getSerial()
    {
        if (isset($this->serial)) {
            return $this->serial;
        }

        throw new Exception("Unable to create Invoice: serial not set.");
    }

    /**
     * Set seller
     *
     * @param  LegalPerson    $seller
     * @return InvoiceBuilder Instance for chaining
     */
    public function setSeller(LegalPerson $seller)
    {
        $this->seller = $seller;
        return $this;
    }

    /**
     * Get seller
     *
     * @return LegalPerson
     * @throws Exception   If seller is not set
     */
    public function getSeller()
    {
        if (isset($this->seller)) {
            return $this->seller;
        }

        throw new Exception("Unable to create Invoice: seller not set.");
    }

    /**
     * Set buyer
     *
     * @param  LegalPerson    $buyer
     * @return InvoiceBuilder Instance for chaining
     */
    public function setBuyer(LegalPerson $buyer)
    {
        $this->buyer = $buyer;
        return $this;
    }

    /**
     * Get buyer
     *
     * @return LegalPerson
     * @throws Exception   If buyer is not set
     */
    public function getBuyer()
    {
        if (isset($this->buyer)) {
            return $this->buyer;
        }

        throw new Exception("Unable to create Invoice: buyer not set.");
    }

    /**
     * Set date of invoice creation
     *
     * @param  DateTime       $date
     * @return InvoiceBuilder Instance for chaining
     */
    public function setBillDate(DateTime $date)
    {
        $this->billDate = $date;
        return $this;
    }

    /**
     * Get date of invoice creation
     *
     * @return DateTime
     */
    public function getBillDate()
    {
        return isset($this->billDate) ? $this->billDate : new DateTime;
    }

    /**
     * Set if OCR may be generated from Invoice serial
     *
     * @param  boolean        $flag
     * @return InvoiceBuilder Instance for chaining
     */
    public function generateOCR($flag = true)
    {
        $this->generateOCR = $flag;
        return $this;
    }

    /**
     * Set invoice reference number
     *
     * @param  OCR            $ocr
     * @return InvoiceBuilder Instance for chaining
     */
    public function setOCR(OCR $ocr)
    {
        $this->ocr = $ocr;
        return $this;
    }

    /**
     * Get invoice reference number
     *
     * @return OCR
     * @throws Exception If ocr is not set or can not be generated
     */
    public function getOCR()
    {
        if (isset($this->ocr)) {
            return $this->ocr;
        }

        if ($this->generateOCR) {
            return OCR::create($this->getSerial());
        }

        throw new Exception("Unable to generate Invoice: OCR not set.");
    }

    /**
     * Set invoice message
     *
     * @param  string         $message
     * @return InvoiceBuilder Instance for chaining
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Set number of days before invoice expires
     *
     * @param  int            $term Number of days
     * @return InvoiceBuilder Instance for chaining
     */
    public function setPaymentTerm($term)
    {
        $this->paymentTerm = $term;
        return $this;
    }

    /**
     * Set deduction (amount prepaid)
     *
     * @param  Amount         $deduction
     * @return InvoiceBuilder Instance for chaining
     */
    public function setDeduction(Amount $deduction)
    {
        $this->deduction = $deduction;
        return $this;
    }

    /**
     * Set the 3-letter ISO 4217 currency code indicating the invoice currency
     *
     * @param  string $currency Currency code
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * Add post to invoice
     *
     * @param  InvoicePost    $post
     * @return InvoiceBuilder Instance for chaining
     */
    public function addPost(InvoicePost $post)
    {
        $this->posts[] = $post;
        return $this;
    }
}
