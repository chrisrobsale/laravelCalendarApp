<?php
namespace App\Http\Controllers;

use App\Models\calendarEvent;
use Illuminate\Http\Request;

class CalendarEventController extends Controller
{

    public function index(Request $req)
    {
        $currData = $req->session()->get('currData');
        $monthToday = date('F');
        $yearToday = date('Y');
        $arrDays = [];
        for($i = 1; $i <= date('t'); $i++)
        {
            $genDate = date('Y') . "-" . date('m') . "-" . str_pad($i, 2, '0', STR_PAD_LEFT);
            $arrDays[$i]['dateValue'] = $i;
            $arrDays[$i]['dayNumber'] = date('w', strtotime($genDate));
            $arrDays[$i]['dayText'] = date('D', strtotime($genDate));
            $arrDays[$i]['dayValue'] = $genDate;
            $arrDays[$i]['isSelected'] = false;
            if($currData && $currData["daysSelected"] && in_array($arrDays[$i]['dayNumber'], $currData["arrdaysSelected"])){
                if($this->check_in_range($currData['dateFrom'], $currData['dateTo'], $genDate)){
                    $arrDays[$i]['isSelected'] = true;
                }
            }
        }
        return view('welcome', ['currMonth'=>$monthToday, 'currYear'=> $yearToday, 'dayList'=>$arrDays, 'currData'=>$currData]);
    }

    public function save(Request $req){
        $req->validate([
            'eventName' => 'required',
            'dateFrom' => 'required|date|before_or_equal:dateTo',
            'dateTo' => 'required|date|after_or_equal:dateFrom'
        ]);
        $data = $req->input();
        $arrdaysSelected = $data['daysSelected'];
        $data['daysSelected'] = join(",",$data['daysSelected']);
        $calEvent = new calendarEvent();
        $calEvent->eventName = $data["eventName"];
        $calEvent->dateFrom = date('Y-m-d',strtotime($data["dateFrom"]));
        $calEvent->dateTo = date('Y-m-d',strtotime($data["dateTo"]));
        $calEvent->daySelected = $data['daysSelected'];
        $calEvent->save();
        $data["arrdaysSelected"] = $arrdaysSelected;
        $req->session()->put('currData', $data);
        return redirect()->back();
    }

    private function check_in_range($start_date, $end_date, $date_from_user) {
        $start = strtotime($start_date);
        $end = strtotime($end_date);
        $check = strtotime($date_from_user);
        
        return (($start <= $check ) && ($check <= $end));
      }
}
?>