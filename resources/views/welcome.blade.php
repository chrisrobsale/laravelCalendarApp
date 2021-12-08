<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Calendar Events</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="/css/app.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <style>
            body {
                font-family: 'Nunito';
            }
        </style>
    </head>
    <body class="bg-light antialiased">
      <main class="container-xl my-3 p-3 bg-body rounded shadow">
      
        <div class="row mb-2">
          <h4 class="border-bottom pb-2 mb-1 fw-bolder">Calendar</h6>
        </div>
        
        <div class="row mb-2">
          <div class="col-4">
            <form class = "eventForm" action="{{ route('calendarEvent.save') }}" method="POST">
              @csrf
              <div class = "row">
                <div class="col-12 pb-1">
                  <label for="eventName" class="form-label">Event</label>
                  <input type="text" class="form-control" id="eventName" name="eventName">
                </div>
                <div class="col-6 pb-1">
                  <label for="dateFrom" class="form-label">From</label>
                  <input type="text" class="form-control" id="dateFrom" name="dateFrom">
                </div>
                <div class="col-6 pb-1">
                  <label for="dateTo" class="form-label">To</label>
                  <input type="text" class="form-control" id="dateTo" name="dateTo">
                </div>
                <div class="col-12 pb-1">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="daysSelected[]" value="0">
                    <label class="form-check-label" for="inlineCheckbox1">Sun</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="daysSelected[]" value="1">
                    <label class="form-check-label" for="inlineCheckbox2">Mon</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox3" name="daysSelected[]" value="2">
                    <label class="form-check-label" for="inlineCheckbox2">Tue</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox4" name="daysSelected[]" value="3">
                    <label class="form-check-label" for="inlineCheckbox2">Wed</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox5" name="daysSelected[]" value="4">
                    <label class="form-check-label" for="inlineCheckbox2">Thu</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox6" name="daysSelected[]" value="5">
                    <label class="form-check-label" for="inlineCheckbox2">Fri</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox7" name="daysSelected[]" value="6">
                    <label class="form-check-label" for="inlineCheckbox2">Sat</label>
                  </div>
                </div>
                
                @if($errors->any())
                  <div class = "invalid-feedback" style="display: block;">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
                @endif
                <div>
                  <button type="submit" class="btn btn-primary">Save</button>
                </div>
              </div>
            </form>
          </div>
          <div class="col-8">
            <div class="row">
              <h2 class="border-bottom pb-2 mb-1 fw-bolder">{{ $currMonth }} {{ $currYear }}</h2>
            </div>
            @for ($i = 1; $i <= count($dayList); $i++)
              @if($dayList[$i]['isSelected'])
              <div class="row border-bottom mt-2 mb-2 bg-success text-white">
                <div class="col-3">
                  <p class="dateVal">{{ $dayList[$i]['dateValue'] }} {{ $dayList[$i]['dayText'] }}</p>
                </div>
                <div class="col-9">
                  <p class="eventName">{{ $currData["eventName"] }}</p>
                </div>
              </div>
              @else
              <div class="row border-bottom mt-2 mb-2">
                <div class="col-3">
                  <p class="dateVal">{{ $dayList[$i]['dateValue'] }} {{ $dayList[$i]['dayText'] }}</p>
                </div>
                <div class="col-9">
                  <p class="eventName"></p>
                </div>
              </div>
              @endif
            @endfor
            
              
              
            
          </div>
        </div>
      </main>
      <script src="/js/app.js"></script>
      <script type="text/javascript">
        var today = new Date();
        var startDate = new Date(today.getFullYear(), today.getMonth(), 1);
        var endDate = new Date(today.getFullYear(), today.getMonth() + 1, 0);
        $('#dateFrom').datepicker({  
            format: 'yyyy-mm-dd',
            startDate: startDate,
            endDate: endDate
         });  
         $('#dateTo').datepicker({  
            format: 'yyyy-mm-dd',
            startDate: startDate,
            endDate: endDate
         });  
    </script> 
    @if(Session::has('currData'))
      <script>
        toastr.success("Event Successfully Saved!");
      </script>
    @endif
    </body>
</html>
