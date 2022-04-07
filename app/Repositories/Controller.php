<?php

namespace App\Repositories;

use Illuminate\Http\Request;

define('NOT_SUBMITTED',"Belum Di Ajukan");
define('APRROVED_DIREKSI',"Disetujui (Direksi)");
define('NOT_YET_PAID',"Belum Di Bayar");
define('PAID',"Telah Di Bayar");

class Controller
{

    /**
     * @var Request
     */
    protected Request $request;

    /**
     * @var string[]
     */
    public array $convAnswer = [
        1 => 'a',
        2 => 'b',
        3 => 'c',
        4 => 'd',
        5 => 'e',
    ];

    public array $convNumberToRomanNumber = [
        1 => 'I',
        2 => 'II',
        3 => 'III',
        4 => 'IV',
        5 => 'V',
        6 => 'VI',
        7 => 'VII',
        8 => 'VIII',
        9 => 'IX',
        10 => 'X',
        11 => 'XI',
        12 => 'XII',
    ];

    public array $convMonthIntlToIndonesian = [
        "Jan" => "Januari",
        "Feb" => "Februari",
        "Mar" => "Maret",
        "Apr" => "April",
        "May" => "Mei",
        "Jun" => "Juni",
        "Jul" => "Juli",
        "Aug" => "Agustus",
        "Sep" => "September",
        "Oct" => "Oktober",
        "Nov" => "November",
        "Dec" => "Desember",
    ];

    protected int $defaultLimit = 10;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /***
     * @param bool $isSuccess
     * @param string $message
     * @param null $data
     * @return object
     */
    public function callback(bool $isSuccess, string $message = "", $data = null): object
    {
        return (object)[
            "is_success" => $isSuccess,
            "message" => $message,
            "data" => $data
        ];
    }

    /**
     * @return string[]
     */
    public function dict_day_local(): array
    {
        return [
            "Minggu" => "Sunday",
            "Senin" => "Monday",
            "Selasa" => "Tuesday",
            "Rabu" => "Wednesday",
            "Kamis" => "Thursday",
            "Jumat" => "Friday",
            "Sabtu" => "Saturday",
        ];
    }

    /**
     * @return Request
     */
    public function request_data(): Request
    {
        return $this->request;
    }

    /**
     * @param $date
     * @return string
     */
    public function conv_date_to_indonesia_format($date): string
    {
        $dayNumber = date('d', strtotime($date));
        $month = date('M', strtotime($date));
        $year = date('Y', strtotime($date));

        return sprintf('%s %s %s', $dayNumber, $this->convMonthIntlToIndonesian[$month], $year);
    }

    /**
     * @return mixed
     */
    public function getPage()
    {
        return $this->request->get("page", 1);
    }

    /**
     * @return mixed
     */
    public function getLimit()
    {
        return $this->request->get("limit", $this->defaultLimit);
    }

    /**
     * @param string $key
     * @param string $default
     * @return mixed
     */
    public function get_query_url(string $key, string $default = "")
    {
        return $this->request->get($key, $default);
    }

    /**
     * @return mixed
     */
    public function user_division()
    {
        return auth()->user()->divisi;
    }

    /**
     * @return mixed
     */
    public function user_level()
    {
        return auth()->user()->level;
    }
}
