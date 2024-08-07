<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{ $user->name }} - Resume</title>
	<style type="text/css">
        .sky-resume {
            padding:40px;
            background: #fff;
            display: block;
            margin: auto;
            max-width:900px;
            width:100%;
            box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
        }
        .content-name .person {
          color:#309999;
          text-transform: uppercase;
          font-size:30px;
          margin-top: 10px;
          margin-bottom: 20px;
        }
        .address {
          list-style: none;
          font-size: 14px;
          padding-left: 0px;
        }
        .address li:nth-child(1) {
          display: inline-block;
          border-right: 1px solid black;
          padding-right: 10px;
          text-transform: capitalize;
        }
        .address li:nth-child(2) {
          display: inline-block;
          border-right: 1px solid black;
          padding-right: 10px;
          padding-left: 10px;
        }
        .address li:nth-child(3) {
          display: inline-block;
          padding-right: 10px;
          padding-left: 10px;
          
        }
        .side-head {
          color:#309999;
          text-transform: capitalize;
          font-weight:600;
          margin-bottom: 20px;
        }
        .sec1 {
          display:inline-block;
          width:38%;
          margin-right: 10px;
          padding-left: 15px;
          text-transform: capitalize;
        }
        .sec2 {
          display:inline-block;
          width:30%;
        }
        .dummy {
          display: inline-block;
          width:20%;
          margin-right:10px;
        }
        .lft {
          width:20%;
          display: inline-block;
          vertical-align: top;
          margin-right:10px;
        }
        .ryt {
          width:65%;
          display: inline-block;
        }
         .font-bold {
          font-weight:600;
          text-transform: capitalize;
          font-size:14px;
        }

        .text {
          text-transform: capitalize;
        }
        .contentbold {
          font-weight: 600;
          text-transform: capitalize;
          display: inline-block;
       }
       .content {
          color: #000;
          text-transform: capitalize;
          display: inline-block;
       }
       .skill_progress {
          width: 47%;
          height: 6px;
          background: #309999;
          position: relative;
          margin-bottom: 34px;
          margin-top: 25px;
          display: inline-block;
          margin-right: 25px;
       }
       .skill_progress1 {
          width: 47%;
          height: 6px;
          background: #ccc;
          position: relative;
          margin-bottom: 34px;
          margin-top: 25px;
          display: inline-block;
        } 
        .skill_progress1 .progress {
          position: absolute;
          top: 0;
          left: 0;
          height: 100%;
          background: #309999;
        }
        table{
          page-break-inside: avoid;
        }
    </style>
</head>
<body>
	<div class="sky-resume">
	     <div class="content-name">
	         <p class="person"><b>{{ $user->name }}</b></p>
	         <ul class="address" style="margin-bottom:0px;margin-top:0px;">
	            <li>{{ $user->city }}, {{ $user->country }} {{ $user->pin_code }}</li>
	            <li>{{ $user->mobile_num }}</li>
	            <li>{{ $user->email }}</li>
	         </ul>
	         <div class="mb-4">
	           <h5 class="side-head">summary</h5>
	           <p class="" style="font-size:14px;">
	               {{ $user->summary }}
	           </p>
	         </div>
	         <div class="mb-4">
	           <h5 class="side-head">skill</h5>
	           <div class="" style="width:100%;">
	              <p class="dummy"></p>
	              @php
	                $skillcount = count($candidate_skills);
	                $equal = (round($skillcount/2));
	              @endphp
	                @if($skillcount == "1")
	                    <ul class="sec1" style="font-size:14px;vertical-align: top;">
	                        @foreach($candidate_skills as $skill)
	                            <li>{{ $skill->name }}</li>
	                        @endforeach
	                    </ul>
	                @else
	                    <ul class="sec1" style="font-size:14px;vertical-align: top;">
	                        @foreach($candidate_skills as $skill)
	                            @if($loop->iteration <= $equal)
	                                <li>{{ $skill->name }}</li>
	                            @endif
	                        @endforeach
	                    </ul>
	                    <ul class="sec2" style="font-size:14px;vertical-align: top;">
	                        @foreach($candidate_skills as $skill)
	                            @if($loop->iteration > $equal)
	                                <li>{{ $skill->name }}</li>
	                            @endif
	                        @endforeach
	                    </ul>
	                @endif
	           </div>
	         </div>
           @if($user->fresher != "1" || count($experiences) > 0)
	         <div class="mb-4">
	           <h5 class="side-head">experience</h5>
	            @foreach($experiences as $experience)
                @if($loop->first)
                    <table style="width: 100%;">
                      <tr>
                        <td style="width:20%;vertical-align:top">
                          {{ date('F Y', strtotime($experience->start)) }} @if($experience->currently_working == "1")- {{__('current')}} @else - {{ date('F Y', strtotime($experience->end)) }} @endif
                        </td>
                        <td style="width: 80%;">
                          <p class="font-bold " style="margin-bottom:0px;margin-top:0px;text-align:left!important;font-size:14px;">{{ $experience->designation }}</p>
                          <p class="text" style="margin-bottom:0px;margin-top:5px;font-size:14px;"><b>{{ $experience->company }} </b> - {{ $experience->company_location }}</p>
                              @if(count($experience->responsible) > 0)
                                   <ul class="" style="padding-left:25px;font-size:14px;">
                                      @foreach($experience->responsible as $res)
                                          <li>{{ $res->responsibility }}</li>
                                      @endforeach
                                   </ul>
                              @endif
                        </td>
                      </tr>
                    </table>
                @else
                    <table style="width: 100%;">
                      <tr>
                        <td style="width:20%;vertical-align:top">
                          {{ date('F Y', strtotime($experience->start)) }} @if($experience->currently_working == "1")- {{__('current')}} @else - {{ date('F Y', strtotime($experience->end)) }} @endif
                        </td>
                        <td style="width: 80%;">
                          <p class="font-bold " style="margin-bottom:0px;margin-top:0px;text-align:left!important;font-size:14px;">{{ $experience->designation }}</p>
                          <p class="text" style="margin-bottom:0px;margin-top:5px;font-size:14px;"><b>{{ $experience->company }} </b> - {{ $experience->company_location }}</p>
                              @if(count($experience->responsible) > 0)
                                   <ul class="" style="padding-left:25px;font-size:14px;">
                                      @foreach($experience->responsible as $res)
                                          <li>{{ $res->responsibility }}</li>
                                      @endforeach
                                   </ul>
                              @endif
                        </td>
                      </tr>
                    </table>

                @endif
	             @endforeach
	         </div>
           @endif
	         <div class="mb-4" style="width:100%;">
	          <h5 class="side-head">education and training</h5>
	            @foreach($educations as $education)
                @if($loop->first)
                    <table style="width: 100%;">
                      <tr>
                        <td rowspan="2" style="vertical-align: top;width:20%;font-weight:bold">{{ $education->year }}</td>
                        <td style="width:80%;font-weight:bold">{{ $education->qualification }}</td>
                      </tr>
                      <tr>
                        <td><span style="font-weight:bold">{{ $education->university }}</span>, {{ $education->location }}</td>
                      </tr>
                    </table>
                @else
                    <table style="width: 100%;">
                      <tr>
                        <td rowspan="2" style="vertical-align: top;width:20%;font-weight:bold">{{ $education->year }}</td>
                        <td style="width:80%;font-weight:bold">{{ $education->qualification }}</td>
                      </tr>
                      <tr>
                        <td><span style="font-weight:bold">{{ $education->university }}</span>, {{ $education->location }}</td>
                      </tr>
                    </table>
    	          @endif  
	            @endforeach
	         </div>
	         <div class="mb-4" style="width:100%;">
	          <h5 class="side-head">language</h5>
		        	<ul style="width: 50%;float: left;">
                  @foreach($candidate->languages as $user_lang)
                      @if(fmod($loop->iteration,2) == "1")
                         <li>{{ $user_lang->name  }}</li>
                      @endif
                  @endforeach 
              </ul>
              <ul style="width: 50%;float: left;">
                  @foreach($candidate->languages as $user_lang)
                      @if(fmod($loop->iteration,2) == "0")
                         <li>{{ $user_lang->name  }}</li>
                      @endif
                  @endforeach 
              </ul>
	         </div>

	     </div>
	</div>
</body>
</html>