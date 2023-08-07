<?php

return [
    /*
        |--------------------------------------------------------------------------
        | Validation Language Lines
        |--------------------------------------------------------------------------
        |
        | The following language lines contain the default error messages used by
        | the validator class. Some of these rules have multiple versions such
        | as the size rules. Feel free to tweak each of these messages.
        |
    */

    'docx' => ':attribute مائیکروسافٹ آفس کی قسم .docx یا doc کا فائل ہونا ضروری ہے',
    'potm' => ':attribute مائیکروسافٹ آفس کی قسم .potm کا فائل ہونا ضروری ہے',
    'ppsm' => ':attribute مائیکروسافٹ آفس کی قسم .ppsm کا فائل ہونا ضروری ہے',
    'sldm' => ':attribute مائیکروسافٹ آفس کی قسم .sldm کا فائل ہونا ضروری ہے',
    'pptm' => ':attribute مائیکروسافٹ آفس کی قسم .pptm کا فائل ہونا ضروری ہے',
    'ppam' => ':attribute مائیکروسافٹ آفس کی قسم .ppam کا فائل ہونا ضروری ہے',
    'ppt' => ':attribute مائیکروسافٹ آفس کی قسم .ppt کا فائل ہونا ضروری ہے',
    'xltx' => ':attribute مائیکروسافٹ آفس کی قسم .xltx کا فائل ہونا ضروری ہے',
    'xlsx' => ':attribute مائیکروسافٹ آفس کی قسم .xlsx کا فائل ہونا ضروری ہے',
    'xls' => ':attribute مائیکروسافٹ آفس کی قسم .xls کا فائل ہونا ضروری ہے',
    'office' => ':attribute مائیکروسافٹ آفس کی قسموں میں سے ایک فائل ہونا ضروری ہے: docx, potm, ppsm, sldm, pptm, ppam, ppt, xltx, xlsx, xls',

    'pdf' => ':attribute .pdf کی قسم کا فائل ہونا ضروری ہے',
    'video' => ':attribute ویڈیو فائل ہونا ضروری ہے اور مندرجہ ذیل اقسام میں سے کوئی ایک: vob, avi, wmv, mkv, mk3d, mks, webm, 3gp, qt, mov, mpeg, mpg, mpe, m1v, m2v, mp4, mp4v, mpg4',
    'mp4' => ':attribute ویڈیو فائل ہونا ضروری ہے اور مندرجہ ذیل اقسام میں سے کوئی ایک: mp4, mp4v, mpg4',
    'mpeg' => ':attribute ویڈیو فائل ہونا ضروری ہے اور مندرجہ ذیل اقسام میں سے کوئی ایک: mpeg, mpg, mpe, m1v, m2v',
    'mov' => ':attribute ویڈیو فائل ہونا ضروری ہے اور مندرجہ ذیل اقسام میں سے کوئی ایک: qt, mov',
    '3gp' => ':attribute .3gp کی قسم کا ویڈیو فائل ہونا ضروری ہے',
    'webm' => ':attribute .webm کی قسم کا ویڈیو فائل ہونا ضروری ہے',
    'mkv' => ':attribute .mkv کی قسم کا ویڈیو فائل ہونا ضروری ہے اور مندرجہ ذیل اقسام میں سے کوئی ایک: mkv, mk3d, mks',
    'wmv' => ':attribute .wmv کی قسم کا ویڈیو فائل ہونا ضروری ہے',
    'avi' => ':attribute .avi کی قسم کا ویڈیو فائل ہونا ضروری ہے',
    'vob' => ':attribute .vob کی قسم کا ویڈیو فائل ہونا ضروری ہے',
    'audio' => ':attribute صوتی فائل ہونا ضروری ہے اور مندرجہ ذیل اقسام میں سے کوئی ایک: xm, wav, ogg, adp, mp3',
    'mp3' => ':attribute صوتی فائل ہونا ضروری ہے اور مندرجہ ذیل اقسام میں سے کوئی ایک: mpga',
    'xm' => ':attribute کو صوتی فائل کی قسموں میں سے xm ہونی چاہئے',
    'wav' => ':attribute کو صوتی فائل کی قسموں میں سے wav ہونی چاہئے',
    'ogg' => ':attribute کو صوتی فائل کی قسموں میں سے ogg ہونی چاہئے',
    'adp' => ':attribute کو صوتی فائل کی قسموں میں سے adp ہونی چاہئے',

    'accepted' => ':attribute قبول ہونا ضروری ہے',
    'active_url' => ':attribute درست URL نہیں ہے',
    'after' => ':attribute کا تاریخ :date کے بعد کی ہونی چاہئے',
    'after_or_equal' => ':attribute کا تاریخ تاریخ :date کے بعد یا اس کے مساوی ہونی چاہئے',
    'alpha' => ':attribute میں صرف حروف ہو سکتے ہیں',
    'alpha_dash' => ':attribute میں حروف، اعداد، اور خطوں کے علاوہ کچھ نہیں ہو سکتا',
    'alpha_num' => ':attribute میں صرف حروف اور اعداد ہو سکتے ہیں',
    'array' => ':attribute ایک مصفوفہ ہونا ضروری ہے',
    'before' => ':attribute کا تاریخ :date کے پہلے کی ہونی چاہئے',
    'before_or_equal' => ':attribute کا تاریخ تاریخ :date کے پہلے یا اس کے مساوی ہونی چاہئے',
    'between' => [
        'numeric' => ':attribute کی قیمت :min اور :max کے درمیان ہونی چاہئے',
        'file' => ':attribute کا حجم :min اور :max کلوبائٹ کے درمیان ہونا چاہئے',
        'string' => ':attribute کی تعداد :min اور :max کے درمیان ہونی چاہئے',
        'array' => ':attribute میں :min اور :max آئٹمز کے درمیان ہونے چاہئے',
    ],
    'boolean' => ':attribute کی قیمت صحیح یا غلط ہونی چاہئے',
    'confirmed' => ':attribute کی تصدیق مطابق نہیں ہے',
    'date' => ':attribute درست تاریخ نہیں ہے',
    'date_format' => ':attribute کی شکل :format کے ساتھ مطابق نہیں ہے',
    'different' => ':attribute اور :other مختلف ہونے چاہئے',
    'digits' => ':attribute میں :digits ہندسے ہونی چاہئیں',
    'digits_between' => ':attribute کی تعداد :min اور :max کے درمیان ہونی چاہئیں',
    'dimensions' => ':attribute کی تصویر غلط ابعاد رکھتی ہے',
    'distinct' => ':attribute کی قیمت مکرر ہے',
    'email' => ':attribute درست ای میل پتہ نہیں ہے',
    'exists' => 'منتخب کردہ :attribute درست نہیں ہے',
    'file' => ':attribute فائل ہونی ضروری ہے',
    'filled' => ':attribute ضروری ہے',
    'image' => ':attribute تصویر ہونا ضروری ہے',
    'in' => ':attribute غلط ہے',
    'in_array' => ':attribute :other میں موجود نہیں ہے',
    'integer' => ':attribute عدد ہونا ضروری ہے',
    'ip' => ':attribute درست IP پتہ نہیں ہے',
    'ipv4' => ':attribute درست IPv4 پتہ نہیں ہے',
    'ipv6' => ':attribute درست IPv6 پتہ نہیں ہے',
    'json' => ':attribute درست JSON نہیں ہے',
    'max' => [
        'numeric' => ':attribute کی قیمت :max سے زیادہ نہیں ہو سکتی',
        'file' => ':attribute کا حجم :max کلوبائٹ سے زیادہ نہیں ہو سکتا',
        'string' => ':attribute کی تعداد :max حروف سے زیادہ نہیں ہو سکتی',
        'array' => ':attribute میں :max آئٹمز سے زیادہ نہیں ہو سکتے',
    ],
    'mimes' => 'یہ ملف : :values کی قسم کی ہونی چاہئے۔',
'mimetypes' => 'یہ ملف : :values کی قسم کی ہونی چاہئے۔',
'min' => [
    'numeric' => ':attribute کی قیمت :min یا اس سے زیادہ ہونی چاہئے۔',
    'file' => ':attribute کا حجم کم از کم :min کلوبائٹ ہونا چاہئے۔',
    'string' => ':attribute کی تعداد کم از کم :min حروف یا حرف ہونے چاہئے۔',
    'array' => ':attribute میں کم از کم :min آئٹمز یا عناصر ہونے چاہئیں۔',
],
'not_in' => ':attribute غیر موثر ہے۔',
'numeric' => ':attribute کو عدد ہونا چاہئے۔',
'present' => ':attribute موجود ہونا ضروری ہے۔',
'regex' => ':attribute کی صیغت درست نہیں ہے۔',
'required' => ':attribute ضروری ہے۔',
'required_if' => ':attribute ضروری ہے اگر :other کی قیمت :value ہو۔',
'required_unless' => ':attribute ضروری ہے اگر :other کی قیمت :values نہ ہو۔',
'required_with' => ':attribute ضروری ہے اگر :values موجود ہوں۔',
'required_with_all' => ':attribute ضروری ہے اگر :values موجود ہوں۔',
'required_without' => ':attribute ضروری ہے اگر :values موجود نہ ہوں۔',
'required_without_all' => ':attribute ضروری ہے اگر کوئی بھی :values موجود نہ ہوں۔',
'same' => ':attribute اور :other میں موازنہ ہونا چاہئے۔',
'size' => [
    'numeric' => ':attribute کی قیمت برابر ہونی چاہئے :size کے ساتھ۔',
    'file' => ':attribute کا حجم برابر ہونا چاہئے :size کلوبائٹ کے ساتھ۔',
    'string' => ':attribute کی تعداد برابر ہونی چاہئے :size حروف یا حرف کے ساتھ۔',
    'array' => ':attribute میں برابر ہونی چاہئیں :size آئٹمز یا عناصر کے ساتھ۔',
],
'string' => ':attribute کو متن ہونا چاہئے۔',
'timezone' => ':attribute کو درست وقتی موقع ہونا چاہئے۔',
'unique' => ':attribute پہلے ہی استعمال ہو چکا ہے۔',
'uploaded' => ':attribute کو اپلوڈ کرنے میں ناکامی ہوئی۔',
'url' => ':attribute کی صیغت درست نہیں ہے۔',
'lt' => [
    'numeric' => ':attribute کی قیمت :value سے کم ہونی چاہئے۔',
    'file' => ':attribute کا حجم :value کلوبائٹ سے کم ہونا چاہئے۔',
    'string' => ':attribute کی تعداد :value حروف سے کم ہونی چاہئے۔',
    'array' => ':attribute میں کم از کم :value آئٹمز یا عناصر ہونی چاہئیں۔',
],
'lte' => [
    'numeric' => ':attribute کی قیمت :value سے کم یا اس کے برابر ہونی چاہئے۔',
    'file' => ':attribute کا حجم :value کلوبائٹ سے کم یا اس کے برابر ہونا چاہئے۔',
    'string' => ':attribute کی تعداد :value حروف یا حرف سے کم یا اس کے برابر ہونی چاہئے۔',
    'array' => ':attribute میں کم از کم :value آئٹمز یا عناصر ہونے چاہئیں۔',
],
'gt' => [
    'numeric' => ':attribute کی قیمت :value سے زیادہ ہونی چاہئے۔',
    'file' => ':attribute کا حجم :value کلوبائٹ سے زیادہ ہونا چاہئے۔',
    'string' => ':attribute کی تعداد :value حروف یا حرف سے زیادہ ہونی چاہئے۔',
    'array' => ':attribute میں کم از کم :value آئٹمز یا عناصر ہونے چاہئیں۔',
],
'gte' => [
    'numeric' => ':attribute کی قیمت :value سے زیادہ یا اس کے برابر ہونی چاہئے۔',
    'file' => ':attribute کا حجم :value کلوبائٹ سے زیادہ یا اس کے برابر ہونا چاہئے۔',
    'string' => ':attribute کی تعداد :value حروف یا حرف سے زیادہ یا اس کے برابر ہونی چاہئے۔',
    'array' => ':attribute میں کم از کم :value آئٹمز یا عناصر ہونے چاہئیں۔',
],
/*
	|--------------------------------------------------------------------------
	| کسٹم ویریفیکیشن زبان کی لائنز
	|--------------------------------------------------------------------------
	|
	| یہاں آپ خصوصی ویریفیکیشن پیغامات کو انتخاب کرنے کے لئے مخصوص اندراج کرسکتے ہیں
	| کسی خصوصی خصوصیت کے لئے پیغام کو تعین کرنے کے لئے "خصوصیت.قاعدہ" کا معاشرتی قاعدہ استعمال کیا جا سکتا ہے۔
	|
*/

'custom' => [
	'attribute-name' => [
		'rule-name' => 'خصوصی پیغام',
	],
],

/*
	|--------------------------------------------------------------------------
	| کسٹم ویریفیکیشن ایٹریبیوٹز
	|--------------------------------------------------------------------------
	|
	| مندرجہ ذیل زبانی لائنز کا استعمال خصوصیت کے جگہ پر کچھ ایسے متاثر کن کرنے کے لئے کیا جاتا ہے
	| مثال: "ای میل ایڈریس" بجائے "ای میل۔ یہ سادہ طور پر ہمیں پیغامات کو تھوڑا سا صاف بنانے میں مدد دیتا ہے۔
	|
*/

'attributes' => [
	'name' => 'نام',
	'username' => 'صارف کا نام',
	'email' => 'ای میل ایڈریس',
	'first_name' => 'پہلا نام',
	'last_name' => 'آخری نام',
	'password' => 'پاس ورڈ',
	'password_confirmation' => 'پاس ورڈ کی تصدیق',
	'city' => 'شہر',
	'country' => 'ملک',
	'address' => 'پتہ',
	'phone' => 'فون',
	'mobile' => 'موبائل',
	'age' => 'عمر',
	'sex' => 'جنس',
	'gender' => 'جنسیت',
	'day' => 'دن',
	'month' => 'مہینہ',
	'year' => 'سال',
	'hour' => 'گھنٹہ',
	'minute' => 'منٹ',
	'second' => 'سیکنڈ',
	'title' => 'عنوان',
	'content' => 'مواد',
	'description' => 'تفصیل',
	'excerpt' => 'خلاصہ',
	'date' => 'تاریخ',
	'time' => 'وقت',
	'available' => 'دستیاب',
	'size' => 'سائز',
],
];
