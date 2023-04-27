#!/bin/bash
int=1;
while(( $int<=5 ));
do
        /www/server/php/56/bin/php /www/wwwroot/weiqihuo.com/cli.php admin/crontab/opt_deal_status;
        /www/server/php/56/bin/php /www/wwwroot/weiqihuo.com/cli.php admin/crontab/auto_commission;
        let "int++";
        sleep 13;
done
