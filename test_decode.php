<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lukas
 * Date: 10.06.13
 * Time: 12:48
 * To change this template use File | Settings | File Templates.
 */

$json =
'[
{"number":"607b21028a1beec63020a14f04510a75c7122f6582c17176b07fcd7acdfa7530","name":"Marco Giualiano"},
{"number":"14a6cf9e59e09ddede1ff1158302d7c0be765279ccfd6b21916b5e2612c0a8c8","name":"Timo Guhl"},
{"number":"3a7a6fee75166c77b0bab052e64b814fe27c061c4975ad9f939e9ebd1f4afb33","name":"Frank Mueller"},
{"number":"b85083ee002ae579b3e3f850db5cf6137708ea9fc0f5c116f32b50f0815a9b06","name":"Jannis Hübl"},
{"number":"75f64854a96364bd48793b6c65fdd146af32245a2e7f122c05e28ad546a6b4bf","name":"Christine Hennrich"},
{"number":"2a30122553381f555988ce6fab85c9d2770604084f0e5f04e4fc8ee33adcef74","name":"Lukas Sei Mädl"},
{"number":"5e766bd64bc8cf3c53001b0428fbb0d76e8e72babdce08c29956622e4473152a","name":"Sebastian Ferwanger"},
{"number":"fbf512e15ec9a296dca3a03daceb9366a1b3d968b1495d61645e62a032debd44","name":"Nicole Kellner"}
]';

$json = utf8_decode($json);

echo json_decode($json, true);

echo json_last_error();