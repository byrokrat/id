<?php

$src = __DIR__ . '/../src/iio/stb';

include_once "$src/Exception.php";

include_once "$src/Exception/InvalidAccountException.php";
include_once "$src/Exception/InvalidAmountException.php";
include_once "$src/Exception/InvalidChartException.php";
include_once "$src/Exception/InvalidCheckDigitException.php";
include_once "$src/Exception/InvalidClearingException.php";
include_once "$src/Exception/InvalidLengthDigitException.php";
include_once "$src/Exception/InvalidStructureException.php";
include_once "$src/Exception/InvalidTemplateException.php";
include_once "$src/Exception/InvalidYearException.php";
include_once "$src/Exception/VerificationNotBalancedException.php";

include_once "$src/Accounting/Account.php";
include_once "$src/Accounting/ChartOfAccounts.php";
include_once "$src/Accounting/ChartOfTemplates.php";
include_once "$src/Accounting/Template.php";
include_once "$src/Accounting/Transaction.php";
include_once "$src/Accounting/Verification.php";
include_once "$src/Accounting/Formatter/SIE.php";
include_once "$src/Accounting/Formatter/VISMAkml.php";

include_once "$src/Banking/AccountInterface.php";
include_once "$src/Banking/NullAccount.php";
include_once "$src/Banking/AbstractAccount.php";
include_once "$src/Banking/AbstractGiro.php";
include_once "$src/Banking/AccountBuilder.php";
include_once "$src/Banking/Bankgiro.php";
include_once "$src/Banking/FakeAccount.php";
include_once "$src/Banking/NordeaPerson.php";
include_once "$src/Banking/NordeaTyp1A.php";
include_once "$src/Banking/NordeaTyp1B.php";
include_once "$src/Banking/PlusGiro.php";
include_once "$src/Banking/SEB.php";
include_once "$src/Banking/StaticAccountBuilder.php";
include_once "$src/Banking/SwedbankTyp1.php";
include_once "$src/Banking/SwedbankTyp2.php";

include_once "$src/ID/IdInterface.php";
include_once "$src/ID/NullId.php";
include_once "$src/ID/PersonalId.php";
include_once "$src/ID/PersonalIdBuilder.php";
include_once "$src/ID/CoordinationId.php";
include_once "$src/ID/CorporateId.php";
include_once "$src/ID/FakeId.php";
include_once "$src/ID/CorporateIdBuilder.php";

include_once "$src/Utils/Amount.php";
include_once "$src/Utils/Modulo10.php";
include_once "$src/Utils/Modulo11.php";
include_once "$src/Utils/OCR.php";
