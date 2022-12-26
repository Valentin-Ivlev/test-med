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
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
        @endif
        <form method="post" action="{{ url('') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group mt-3">
                <label for="doctor_city" class="form-label h6">Город*</label>
                <input type="text" id="doctor_city" name="doctor[city]" class="form-control" />
                <input type="hidden" id="doctor_city_id" name="doctor[city_id]" />
            </div>
            <div class="form-group mt-3">
                <label for="doctor_lmf-name" class="form-label h6">ФИО (полностью)*</label>
                <input type="text" id="doctor_lmf-name" name="doctor[lmf_name]" class="form-control" />
            </div>
            <div class="form-group mt-3">
                <label for="doctor_gender" class="form-label h6">Пол*</label>
                <select class="form-select" id="doctor_gender" name="doctor[gender]">
                    <option selected></option>
                    <option value="male">Мужской</option>
                    <option value="female">Женский</option>
                </select>
            </div>
            <div class="form-group mt-3">
                <label for="doctor_phone" class="form-label h6">Номер телефона*</label>
                <input type="text" id="doctor_phone" name="doctor[phone]" placeholder="+7 ___ ___-__-__" class="form-control" />
            </div>
            <div class="form-group mt-3">
                <label for="doctor_email" class="form-label h6">E-mail</label>
                <input type="text" id="doctor_email" name="doctor[email]" class="form-control" />
            </div>
            <div class="form-group mt-3">
                <label for="doctor_speciality" class="form-label h6">Желаемая специализация в сервисе*</label>
                <input type="text" id="doctor_speciality" name="doctor[speciality]" class="form-control" />
                <input type="hidden" id="doctor_speciality_id" name="doctor[speciality_id]" />
            </div>
            <div class="form-group mt-3">
                <label for="doctor_edu_city_0" class="form-label h6">Образование*</label>
                <span id="edus"></span>
                <button type="button" id="add_edu" class="btn btn-link"><b>+</b> Добавить еще</button>
            </div>
            <div class="form-group mt-3">
                <label for="doctor_cert_name_0" class="form-label h6">Курсы и сертификаты</label>
                <span id="certs"></span>
                <button type="button" id="add_cert" class="btn btn-link"><b>+</b> Добавить еще</button>
            </div>
            <div class="form-group mt-3">
                <label for="doctor_job_city_0" class="form-label h6">Прием в клиниках*</label>
                <span id="jobs"></span>
                <button type="button" id="add_job" class="btn btn-link"><b>+</b> Добавить еще</button>
            </div>
            <div class="form-group mt-3">
                <label for="additional_info" class="form-label h6">Дополнительно о себе</label>
                <textarea id="additional_info" name="doctor[additional_info]" class="form-control" rows="3"></textarea>
            </div>
            <div class="mt-3 h6">Резюме</div>
            <div><small>Если у вас есть готовое резюме, то можно приложить его в этом поле</small></div>
            <!-- <button type="button" id="add_cv" class="btn btn-info">Загрузить</button> -->
            <input type="file" name="cv_file">
            <small class="text-muted">Максимальный размер файла до 5 Мб</small>
            <div class="form-group mt-3">
                <button type="submit" id="submit" class="form-control btn btn-success">Зарегистрироваться</button>
                <div class="form-check mt-3">
                    <input class="form-check-input" type="checkbox" value="" id="agreement" checked>
                    <label class="form-check-label" for="agreement"><small>Нажимая кнопку "Зарегистрироваться" даю согласие на обработку моих персональных данных, а также ознакомлен с условиями и политикой в отношении их обработки</small></label>
                </div>
            </div>
        </form>
    </div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js">
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            add_edus();
            add_certs();
            add_jobs();
        });
        var cityroute = "{{ url('city-select') }}";
        var specialityroute = "{{ url('speciality-select') }}";
        $('#doctor_city').typeahead({
            source: function (query, process) {
                return $.get(cityroute, {
                    query: query
                }, function (data) {
                    return process(data);
                });
            },
            afterSelect: function (item) {
                $('#doctor_city_id').val(item.id);
            }
        });
        $('#doctor_phone').mask('+7 999 999-99-99');
        $('#doctor_speciality').typeahead({
            source: function (query, process) {
                return $.get(specialityroute, {
                    query: query
                }, function (data) {
                    return process(data);
                });
            },
            afterSelect: function (item) {
                $('#doctor_speciality_id').val(item.id);
            }
        });
        var edu = -1, cert = -1, job = -1;
        $("#add_edu").click(function() {add_edus();});
        $("#add_cert").click(function() {add_certs()});
        $("#add_job").click(function() {add_jobs()});
        function add_edus() {
            edu++;
            $("#edus").append('<input type="text" id="doctor_edu_city_'+edu+'" name="doctor[edu_city]['+edu+']" placeholder="Город" class="form-control'+(edu===0?'':' mt-4')+'" /><input type="hidden" id="doctor_edu_city_id_'+edu+'" name="doctor[edu_city_id]['+edu+']" /><input type="text" id="doctor_edu_org_'+edu+'" name="doctor[edu_org]['+edu+']" placeholder="Учебное заведение" class="form-control mt-2" /><input type="text" id="doctor_edu_end_year_'+edu+'" name="doctor[edu_end_year]['+edu+']" placeholder="Год окончания" class="form-control mt-2" />');
            $('#doctor_edu_city_'+edu).typeahead({
                source: function (query, process) {
                    return $.get(cityroute, {
                        query: query
                    }, function (data) {
                        return process(data);
                    });
                },
                afterSelect: function (item) {
                    $('#doctor_edu_city_id_'+edu).val(item.id);
                }
            });
            
        }
        function add_certs() {
            cert++;
            $("#certs").append('<input type="text" id="doctor_cert_name_'+cert+'" name="doctor[cert_name]['+cert+']" placeholder="Название" class="form-control'+(cert===0?'':' mt-4')+'" /><input type="text" id="doctor_cert_year_'+cert+'" name="doctor[cert_year]['+cert+']" placeholder="Год" class="form-control mt-2" />');
        }
        function add_jobs() {
            job++;
            $("#jobs").append('<input type="text" id="doctor_job_city_'+job+'" name="doctor[job_city]['+job+']" placeholder="Город" class="form-control'+(job===0?'':' mt-4')+'" /><input type="hidden" id="doctor_job_city_id_'+job+'" name="doctor[job_city_id]['+job+']" /><input type="text" id="doctor_job_name_'+job+'" name="doctor[job_name]['+job+']" placeholder="Название учреждения" class="form-control mt-2" />');
            $('#doctor_job_city_'+job).typeahead({
                source: function (query, process) {
                    return $.get(cityroute, {
                        query: query
                    }, function (data) {
                        return process(data);
                    });
                },
                afterSelect: function (item) {
                    $('#doctor_job_city_id_'+job).val(item.id);
                }
            });
        }
        $("#agreement").click(function() {
            if ($(this).is(':checked')) $("#submit").removeClass('disabled');
            else $("#submit").addClass('disabled');
        });
    </script>
</body>
</html>