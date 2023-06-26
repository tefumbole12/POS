<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    protected $fillable =[

        "site_title", "site_logo","email_header", "email_footer", "email_water_mark", "currency", "currency_position", "staff_access", "date_format", "theme", "developed_by", "invoice_format", "state"
    ];
}
