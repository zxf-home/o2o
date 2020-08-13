<?php
/**
 * Created by PhpStorm.
 * User: zxf36
 * Date: 2019/11/7
 * Time: 14:54
 */
return [
    //应用ID,您的APPID。
    'app_id' => "2016101700704153",

    //商户私钥
    'merchant_private_key' => "MIIEowIBAAKCAQEAswP2MqTHKOSt52/rparh7ObL74ciPVZA5Q4AdaJzWThWJ6PhbsgbUOQnUvxYMDSIDvz/4STDhpy+Ywqtb6C1gUgQga3/W9z7CoHtoJMsnBH0TAFjsbeaTS5P4uP/qPFV5n4EM6IkWCQUnnrVQ26pQ/d8A5MPjB1FCrQxay8HE3vlxwtqy4XVWPwOtwKRbwtjbtrMdgozrVmTVujoow5O/I9QddNT+NymyRWD0wqM91rz2e1+h55BvghR8V64ouqRGtpWW5NYUjLYO8ejoIEweLYC9jKdMujn1XnpKwN37lk51x2uoOQJAPQkAiQ8U5zlIdkDKjkn1XfSHFQZtO/kHwIDAQABAoIBAHUY8VGdUZ1hQJQ0NKuQhOpG6j2LYo1Gv3pVV12bXuKMpGaXn12szZlzNHnnEPSvWBSdz+8A8lk6bJsyn9J2CGRBtHJvU6tOeHQeG0c/Hh4U7H1PJ1xXojo8QgtDYreq7aqw4aS4uhdhuo8UAC5004ne+CMKblAT0Va4Gd9nyrQl7MzFn0P/ckpGVzAGbcykXD+XrmcoT/eC2nFKFx2C3VRGFGlvS0C3x2UNzaOGZyNBl2LxCnOSwWgR7jw2Ilcvims7Rhbi7UxqtqWE0X9wRqavffJGBP0KEx+cCJRXSlZRknMxAdzHxlSysDE5F3jk51UHmeZSMxTBzPlpihUf7wECgYEA7XTiKSCueuX8OWlYfy7sgSjZ5C8srqWuuSlPr6SyFtRpB4v/dn6gukDzBmxSYvGhFROJhr6bYrR03VX0T68ZhCDAfvsGdrAC1zBD9Z0Q4G8xUgiW4AD2UXyc1Q5n6cNLIfWWNXLadE07WCUZQ0GqR4JLyfNhKru7SalQGUzA3oECgYEAwP7AjgeNpKSeyN/Gl9ShIgP1CSDEhwUC1VQI+WjV3pMnVnQ/OEz7AVBxD6PJGhL0d2t+NIN2ulq6qGL+NjWJIU/YG+5cF3XRXtc90SMn2gr/mjsvyZL1Cmojg27/7F4pRxs/rO6DSf5U+XCZ9e9gGupdgptOAS3wee5MRJZwsp8CgYBAmF89mOpd/FpUs9ejIXys1hQQAtVA3UlejWJkAYWAuF+p8eeYsHHAuRJjWOxAhkKvnRT4VrmmbDiuTUectaFXVCGJaXgkqVTcfQC/u+5vX1AnZLbGUPywxhlTzAtwh/PUVR57g7bxlGDkZZMtvJs5wLQlR9PS8CbOrwRfHYYKAQKBgAddcXG6HhCra5fU2lpO9fs7VW2Mv5M7gLktZM5HzumYigbFlugKIAYT0My8/l6tXID2LDHK1owUDE2CwZrF/j60MlYWiZMnnt7Urfo+MjYi91AmdBNoNUu5czN/1+poSYD6LDroO0BmoU2Hm4iEIxHD4d+rF5X579RnYKe5agGXAoGBAIzW6XqMivpCqQ4ApOz7CBQ1cjuG4BWDZBNboPNPs2B8G7kucQYQ48wtDKrqPhMqROKojjnRjmFVVDcGmp9QEZlk/AsqFzovcbuHaaTVDDJBb/TXRozjCyDZl7Ipd71i8Z8UzqAc6qL5CSZmJokd9I95Dw4Xftk7YfFe+7eskbRR",

    //异步通知地址
    'notify_url' => "http://101.200.120.154/o2o/public/index.php/index/pay/notify_url",

    //同步跳转
    'return_url' => "http://101.200.120.154/o2o/public/index.php/index/pay/return_url",

    //编码格式
    'charset' => "UTF-8",

    //签名方式
    'sign_type'=>"RSA2",

    //支付宝网关
    'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

    //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
    'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAkt2LHw45yucVS95Z7KUwSqhInYiwX5mO3ZPsBmsEazo3GDuTVbaDagISP+/YKyRdUYbEtFjMVWWgk+Ob7tdh/rgbi0jeUauQmvth2Y06s7RzQt1aOysteoJFM3HLlt2G4DyOBkIeR8Xobr5cUq/bBLMYP0PDbcl3XoIDdsPKsa5Z1a+gHUQHLDGAw+EdiD794dldhDUm0SzzDzK7E5Gc5T/XqDuSG9DKAJUA7NoDhsiyr3ya63G7aDxqPkeoSVkVb/404aI43BOF9T6op0Owe5eQPSoSSOYri7fh3LM2lIeNZQxYCPc5JMVXciWeHFh+rSia34dk5l0RhGvKq7jGjwIDAQAB",

];