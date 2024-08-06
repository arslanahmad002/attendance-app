<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="icon" type="image/png" href="{{asset('remit-choice-sm.png')}}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Desktop Application</title>
</head>
<body class="bg-light">
    <div class="container bg-white">
        <h1 class="mt-3">Attendance Record</h1>
        <form action="{{route('attendance.index')}}" method="get" class="mt-5 mb-5">
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-3 mb-4">
                    <div class="row g-3 align-items-center">
                        <div class="col-3">
                          <label for="from" class="col-form-label">From</label>
                        </div>
                        <div class="col-9">
                          <input type="date" id="from" value="{{$from != '' ? $from:''}}" name="from" class="form-control" aria-describedby="passwordHelpInline">
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-3 mb-4">
                    <div class="row g-3 align-items-center">
                        <div class="col-3">
                          <label for="to" class="col-form-label">To</label>
                        </div>
                        <div class="col-9">
                          <input type="date" id="to" value="{{$to != '' ? $to:''}}" name="to" class="form-control" aria-describedby="passwordHelpInline">
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-3">
                    <div class="row g-3 align-items-center">
                        <div class="col-3">
                          <label for="user_id" class="col-form-label">User ID </label>
                        </div>
                        <div class="col-9">
                          <input type="number" id="user_id" value="{{$user_id != '' ? $user_id:''}}" name="user_id" class="form-control" aria-describedby="passwordHelpInline">
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-3 mt-3 mt-md-0">
                    <div class="row g-3 align-items-center">
                        <div class="col-3">
                          <label for="reset" class="col-form-label">Reset </label>
                        </div>
                        <div class="col-9">
                          <select name="reset" class="form-control" id="reset">
                            <option value="">Select Option</option>
                            <option value="reset">Reset</option>
                          </select>
                        </div>
                    </div>
                </div>
                <div class="col-1 m-sm-3 m-md-0">
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>
            </div>
        </form>
        <table class="table table-striped mt-3">
            <thead>
              <tr>
                <th scope="col">User Id</th>
                <th scope="col">Time</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($record??[] as $row)
                <tr>
                    <td>{{$row?->user_id}}</td>
                    <td>{{$row?->attendance_timestamp}}</td>
                </tr>
              @empty
                <tr>
                    <td colspan="3" class="p-3 text-center">No Record Found</td>
                </tr>
              @endforelse
            </tbody>
        </table>
        <div class="d-flex justify-content-start mt-3">
            {{$record->links()}}
        </div>
    </div>
</body>
</html>
