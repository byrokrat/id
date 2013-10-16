Swedish Technical Bureaucracy (STB)
===================================

[![Build Status](https://travis-ci.org/iio/Swedish-Technical-Bureaucracy.png?branch=master)](https://travis-ci.org/iio/Swedish-Technical-Bureaucracy)

STB is a collection of classes useful when processing data related to swedish 
bureaucracy and banking systems. Browse the source for a complete listing.


Accounting
----------

The accounting subpackage handles bookkeeping data. Specifically transaction
data can be read and written in the SIE format. Accounting templates from the
VISMA series of accounting software is also supported.


Banking
-------

Data types for accounts in the swedish banking system. Se *AccountBuilder* for
a way to transparently create account objects.


ID
--

Data types for swedish social security and corporation id numbers. Se
*CorporateIdBuilder* and *PersonalIdBuilder* for ways to transparently create ID
objects.


Utils
-----

Some utility classes. *Amount* represent transaction amounts using bcmath for 
arithmetic precision. *OCR* represents transaction numbers used in the swedish
banking system.
