<?php

abstract class PaymentConstants
{

	const ACCOUNT_TYPE_1            = 'dps';
	
	const ACCOUNT_TYPE_2            = 'paypal';

	const DEFAULT_CURRENCY         	= 'NZD';

	const DEFAULT_CURRENCY_SYMBOL   = 'NZD';
	
	const FLAG_YES                  = 'Y';
	
	const FLAG_NO                   = 'N';
	
	const FLAG_ACTIVE               = 'A';
	
	const FLAG_DELETED              = 'D';
	
	const FLAG_APPROVED             = 'A';

	const FLAG_CANCELED             = 'C';
	
	const FLAG_DECLINED             = 'D';
	
	const FLAG_NEW                  = 'N';
	
	const FLAG_PENDING              = 'P';
	
	
	const MSG_NEW_ID                = 1;
	
	const MSG_VIEWED_ID             = 2;
	
	const MSG_ACCEPTED_ID           = 3;
	
	const MSG_DECLINED_ID           = 4;
	
	const MSG_CANCELLED_ID          = 5;
	
	const MSG_DELETED_ID            = 6;
	
	const MSG_SENT_ID               = 7;
	
	
	const HISTORY_NEW_ID            = 1;
	
	const HISTORY_VIEWED_ID         = 2;
	
	const HISTORY_SUCCESS_ID        = 3;
	
	const HISTORY_NTF_ADMIN_ID      = 4;
	
	const HISTORY_NTF_CLIENT_ID     = 5;
	
	const HISTORY_DECLINED_ID       = 6;
	
	const HISTORY_SENT_ID           = 7;
	
	const HISTORY_NTF_FAIL_ADMIN_ID = 8;

};

?>