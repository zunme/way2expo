@extends('desktop.layouts.none')
@section('css')
    <style>

        #image-preview, #image-preview-mobile {
            width: 250px;
            height: 250px;
            border: 2px dashed #ddd;
            border-radius: 3px;
            position: relative;
            overflow: hidden;
            background-color: #ffffff;
            color: #ecf0f1;
        }

        .image-preview label, #callback-preview label {
            position: absolute;
            z-index: 5;
            opacity: 0.8;
            cursor: pointer;
            width: 140px;
            height: 29px;
            text-transform: uppercase;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            margin: auto;
            text-align: center;
            color: #fff;
            background-color: #3c4858;
            border-color: #3c4858;
            box-shadow: 0 2px 2px 0 rgba(60, 72, 88, .14), 0 3px 1px -2px rgba(60, 72, 88, .2), 0 1px 5px 0 rgba(60, 72, 88, .12);
            padding: .40625rem 1.25rem;
            font-size: .6875rem;
            line-height: 1.5;
            border-radius: .2rem;
        }

        .image-preview input, .image-preview-mobile input, #callback-preview input {
            line-height: 200px;
            font-size: 200px;
            position: absolute;
            opacity: 0;
            z-index: 10;
        }
    </style>
@endsection
@section('body-class', '')
@section('header','')
@section('body')
    <div class="main">
        <div class="section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-2">
                        @include('desktop.my.company.lnb')
                    </div>
                    <div class="col-10">
                        <form name="companyEdit" method="post" action="{{ route('my.company.edit') }}">
                            <div class="row">
                                <div class="col-6">
                                    <input type="hidden" name="id" value="{{ $company->id }}">
                                    <div class="form-group">
                                        <label>?????? ???</label>
                                        <input type="text" name="company_name" class="form-control"
                                               value="{{ $company->company_name }}" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label>?????????</label>
                                        <input type="email" name="company_email" class="form-control"
                                               value="{{ $company->company_email }}">
                                    </div>
                                    <div class="form-group">
                                        <label>????????????</label>
                                        <input type="text" name="company_tel1" class="form-control"
                                               value="{{ $company->company_tel1 }}">
                                    </div>
                                    <div class="form-group">
                                        <label>??????</label>
                                        <input type="text" name="company_address1" class="form-control"
                                               value="{{ $company->company_address1 }}">
                                    </div>
                                    <div class="form-group">
                                        <label>????????????</label>
                                        <input type="text" name="company_url" class="form-control"
                                               value="{{ $company->company_url }}">
                                    </div>
                                    <div class="form-group">
                                        <label>?????? ??????</label>
                                        <textarea class="form-control" name="company_info1" rows="5"
                                                  placeholder="?????? ????????? ????????? ?????????.&#13;&#10;(?????? 1,000???)">{{$company->company_info1}}</textarea>
                                    </div>


                                    <button type="submit" class="btn btn-rose btn-block btn-ajax">?????? ?????? ??????
                                    </button>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>?????? ?????? </label>
                                        <div id="image-preview" class="image-preview"
                                             @if(!empty($company->company_image_url))
                                             style="background-image: url('/storage/{{$company->company_image_url}}');
                                             @endif
                                                 background-size: contain; background-position: center center;background-repeat:no-repeat;
                                                 margin: 0 auto;"
                                        >
                                            <label for="image-upload" id="image-label">
                                                @if(!empty($company->company_image_url))??????
                                                @else????????? ?????????
                                                @endif
                                            </label>
                                            <input type="file" name="select_img" id="image-upload"
                                                   accept="image/x-png,image/gif,image/jpeg" data-target="image-preview"
                                                   onchange="updatePhotoPreview(this)">
                                        </div>
                                    </div>
                                    <div class="form-file-upload">
                                        <label>????????????(????????????)</label>
                                        <input type="file" name="select_file" class=""
                                               accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf,zip"
                                        >
                                        @if ( $company->company_attachment_file_url1)
                                            <div id="fileInp_target">
                                                <a href="{!! route('download', ['path'=>$company->company_attachment_file_url1,'name'=>$company->company_attachment_file_name1]) !!}"
                                                   class="btn btn-link"
                                                   download="{{$company->company_attachment_file_name1}}">{{$company->company_attachment_file_name1}}</a>
                                                <i class="fas fa-trash-alt text-danger" onClick='file_delete(this)'
                                                   style="cursor:pointer"></i>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script>
        /* CompanyEdit */
        var companyForm = $('form[name=companyEdit]');
        companyForm.submit(function (e) {
            e.preventDefault();
            var button = $(this).find("button[type=submit]");
            var formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: "{{ route('my.company.edit') }}",
                dataType: "JSON",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function (res) {
                    if (res.result === 'OK') {
                        Swal2.fire({
                            text: res.msg,
                            icon: 'success',
                            showConfirmButton: true,
                        });

                    } else {
                        Swal2.fire({
                            text: res.msg,
                            icon: 'error',
                            showConfirmButton: true,
                        });
                    }

                },
            });
        });

        function updatePhotoPreview(obj) {
            var reader = new FileReader();
            var target = $(obj).data('target');

            reader.onload = (e) => {
                var img = $("#" + target);
                img.css('background-image', 'url(' + e.target.result + ')');
                // $("#" + target +" img.imgInp-origin-img" ).hide();
            };
            reader.readAsDataURL(obj.files[0]);

        }
    </script>
@stop

