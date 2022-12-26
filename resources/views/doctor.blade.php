<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ТЗ</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" />
    <style>
        .container {
            max-width: 600px;
        }

    </style>
</head>
<body>
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-12 text-center h4 mb-3">Добавлен доктор:</div>
            <hr />
            <div class="col-6">Город:</div>
            <div class="col-6 mb-3">{{ $doctor['city'] }}</div>
            <hr />
            <div class="col-6">ФИО:</div>
            <div class="col-6 mb-3">{{ $doctor['lmf_name'] }}</div>
            <hr />
            <div class="col-6">Пол:</div>
            <div class="col-6 mb-3">{{ $doctor['gender']==='male'?'Мужской':'Женский' }}</div>
            <hr />
            <div class="col-6">Номер телефона:</div>
            <div class="col-6 mb-3">{{ $doctor['phone'] }}</div>
            <hr />
            <div class="col-6">E-mail:</div>
            <div class="col-6 mb-3">{{ $doctor['email']!=NULL?$doctor['email']:'не указано' }}</div>
            <hr />
            <div class="col-6">Желаемая специализация в сервисе:</div>
            <div class="col-6 mb-3">{{ $doctor['speciality'] }}</div>
            <hr />
            <div class="col-12 text-center h6 mb-3">Образование:</div>
            <hr />
            @for ($i = 0; $i < count($doctor['edu_city_id']); $i++)
                @if ($doctor['edu_city_id'][$i]!=NULL)
                    <div class="col-6">Город:</div>
                    <div class="col-6 mb-3">{{ $doctor['edu_city'][$i] }}</div>
                    <div class="col-6">Учебное заведение:</div>
                    <div class="col-6 mb-3">{{ $doctor['edu_org'][$i] }}</div>
                    <div class="col-6">Год окончания:</div>
                    <div class="col-6 mb-3">{{ $doctor['edu_end_year'][$i] }}</div>
                    <hr />
                @endif
            @endfor
            <div class="col-12 text-center h6 mb-3">Курсы и сертификаты:</div>
            <hr />
            @for ($i = 0; $i < count($doctor['cert_name']); $i++)
                @if ($doctor['cert_name'][$i]!=NULL)
                    <div class="col-6">Название:</div>
                    <div class="col-6 mb-3">{{ $doctor['cert_name'][$i] }}</div>
                    <div class="col-6">Год:</div>
                    <div class="col-6 mb-3">{{ $doctor['cert_year'][$i] }}</div>
                    <hr />
                @endif
            @endfor
            <div class="col-12 text-center h6 mb-3">Прием в клиниках:</div>
            <hr />
            @for ($i = 0; $i < count($doctor['job_city_id']); $i++)
                @if ($doctor['job_city_id'][$i]!=NULL)
                    <div class="col-6">Город:</div>
                    <div class="col-6 mb-3">{{ $doctor['job_city'][$i] }}</div>
                    <div class="col-6">Название учреждения:</div>
                    <div class="col-6 mb-3">{{ $doctor['job_name'][$i] }}</div>
                    <hr />
                @endif
            @endfor
            <div class="col-12 text-center h6 mb-3">Дополнительно о себе:</div>
            <hr />
            <div class="col-12 mb-3">{{ $doctor['additional_info']!=NULL?$doctor['additional_info']:'не указано' }}</div>
        </div>
    </div>
</body>
</html>