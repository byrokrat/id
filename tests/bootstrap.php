<?php

date_default_timezone_set('UTC');

$src = __DIR__ . '/../src/iio/stb';

include_once "$src/Exception.php";

include_once "$src/Exception/InvalidCheckDigitException.php";
include_once "$src/Exception/InvalidStructureException.php";

include_once "$src/ID/IdInterface.php";
include_once "$src/ID/NullId.php";
include_once "$src/ID/PersonalId.php";
include_once "$src/ID/CoordinationId.php";
include_once "$src/ID/CorporateId.php";
include_once "$src/ID/FakeId.php";
include_once "$src/ID/IdFactory.php";
include_once "$src/ID/PersonalIdFactory.php";
include_once "$src/ID/CoordinationIdFactory.php";
include_once "$src/ID/CorporateIdFactory.php";
include_once "$src/ID/FakeIdFactory.php";
