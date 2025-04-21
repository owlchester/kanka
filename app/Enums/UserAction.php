<?php

namespace App\Enums;

enum UserAction: int
{
    case login = 1;
    case logout = 2;
    case autoLogin = 3;
    case update = 4;
    case bannedLogin = 5;
    case subNew = 10;
    case subCancel = 11;
    case subUpgrade = 12;
    case subDowngrade = 13;
    case subFail = 15;
    case subPaypal = 16;
    case subRenew = 17;
    case campaignNew = 20;
    case campaignJoin = 21;
    case campaignLeave = 22;
    case campaignDelete = 23;
    case passwordUpdate = 30;
    case passwordReset = 31;
    case passwordRequest = 32;
    case passwordAdminUpdate = 35;
    case emailUpdate = 40;
    case socialSwitch = 41;
    case currencySwitch = 42;
    case lang = 43;
    case userSwitch = 50;
    case userRevert = 51;
    case userSwitchLogin = 52;
    case purgeWarningFirst = 60;
    case purgeWarningSecond = 61;
    case notifyYearlySub = 70;
    case failedChargeEmail = 80;
    case yearlyRenewWarning = 81;
    case subCancelManual = 82;
    case subCancelAuto = 83;
    case paymentEdit = 86;
    case paymentAuto = 87;
    case campaignBoost = 90;
    case campaignUpgradeBoost = 91;
    case campaignSuperboost = 92;
    case campaignUnboost = 93;
    case campaignUnboostAuto = 94;
    case campaignPremium = 95;

    // Campaign admin stuff
    case campaign = 100;
    case entity = 101;
    case post = 102;
}
