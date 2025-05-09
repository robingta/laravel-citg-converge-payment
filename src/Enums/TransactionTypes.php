<?php

namespace CITG\ConvergePay\Enums;


enum TransactionTypes: string {
        
        case CC_AUTH_ONLY = 'ccauthonly';
        case CC_AVS_ONLY = 'ccavsonly';
        case CC_SALE = 'ccsale';
        case CC_VERIFY = 'ccverify';
        case CC_GET_TOKEN = 'ccgettoken';
        case CC_CREDIT = 'cccredit';
        case CC_FORCE = 'ccforce';
        case CC_BAL_INQUIRY = 'ccbalinquiry';
        case CC_RETURN = 'ccreturn';
        case CC_VOID = 'ccvoid';
        case CC_COMPLETE = 'cccomplete';
        case CC_DELETE = 'ccdelete';
        case CC_UPDATE_TIP = 'ccupdatetip';
        case CC_SIGNATURE = 'ccsignature';
        case CC_ADD_RECURRING = 'ccaddrecurring';
        case CC_ADD_INSTALL = 'ccaddinstall';
        case CC_UPDATE_TOKEN = 'ccupdatetoken';
        case CC_DELETE_TOKEN = 'ccdeletetoken';
        case CC_QUERY_TOKEN = 'ccquerytoken';
}