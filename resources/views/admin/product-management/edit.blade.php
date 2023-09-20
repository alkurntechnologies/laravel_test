@extends('admin.layouts.master_admin')

@section('page_last_name')
{{config('app.name')}} | Add Product
@endsection

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Add Product</h1>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!--Begin Content-->
<section class="content">

    <!-- Default box -->
    <div class="card">
        <div class="card-header">

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
                    <i class="fas fa-minus"></i></button>
                <!-- <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip"
                            title="Remove">
                        <i class="fas fa-times"></i></button> -->
            </div>
        </div>
        <div class="card-body">

            <form method="post" data-parsley-validate enctype="multipart/form-data">
                @csrf
                <div class="row">
                   
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label><span class="text-danger">*</span>Product Name</label>
                            <input type="text" placeholder="Enter Product Name" class="form-control" name="name"
                                required="" data-parsley-required-message="Please enter name." value="{{@$row->name}}">
                        </div>
                    </div>
                
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="position">Product Images/Videos <span
                                    data-description="Upload below 2 MB size, Only images and videos allowed"
                                    class="tootltip"><i class="fas fa-info"></i></span></label>
                            <div class="inputes">
                                <input type="file" hidden="hidden" class="simpleFile form-control" id="real-file"
                                    name="images" data-parsley-required-message="Please  select images."
                                    data-parsley-errors-container="#profileImage" 
                                    accept="image/png,image/jpg,image/jpeg,video/mp4,video/mov,video/mkv,video/webm">
                                <button class="custom-button-one" type="button">Choose File</button>
                                <span class="inputName">Please select images.</span>
                            </div>
                            <span class="imageError text-danger" role="alert"></span>
                            <span id="profileImage"></span>
                        </div>
                     
                      <div class="image-preview-div">
                      @if($row->images)
                                     @php
                                         $extension = pathinfo($row->images, PATHINFO_EXTENSION); 
                                     @endphp
                                     @if($extension == 'mp4' || $extension == 'mkv' || $extension == 'webm' || $extension == 'mov')
                                         <video src="{{url('storage/app').'/'.$row->images}}" controls="" width="60" height="60"></video>
                                     @else
                                         <img loading="lazy" id="id2" src="{{url('storage/app').'/'.$row->images}}" width="60"  height="60" onerror="this.onerror=null;this.src='{{ asset('/') }}assets/front-end/images/trainImage.jpg'">
                                     @endif
                                    @else
                                    <img loading="lazy" src="{{ asset('/') }}assets/front-end/images/trainImage.jpg" width="60" onerror="this.onerror=null;this.src='{{ asset('/') }}assets/front-end/images/trainImage.jpg'">
                                    @endif
                    </div>
                    
                    </div>
            
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label>Product Price</label>
                            <input type="number" placeholder="Enter Product Price" class="form-control" name="price"
                                data-parsley-required-message="Please enter price." value="{{@$row->price}}">
                        </div>
                    </div>
                  
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label> Stock</label>
                            <input type="text" placeholder="Enter stock" class="form-control" id="stockVal" name="stock"
                                data-parsley-required-message="Please enter stock." value="{{@$row->stock}}">
                        </div>

                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label><span class="text-danger">*</span>Product Type</label>
                            <select class=" form-control" id="type" name="type" required=""
                                data-parsley-required-message="Please select user ."
                                data-parsley-errors-container="#addproductuser">
                                <option value="">Please select</option>
                                <option value="B2B Customer" @if(@$row->type == 'B2B Customer') selected @endif>B2B Customer</option>
                                <option value="B2C Customer" @if(@$row->type == 'B2C Customer') selected @endif>B2C Customer</option>
                            </select>
                            <span id="addproductuser"></span>
                        </div>
                    </div>
                 
                    <div class="col-12"></div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label class="d-flex"> Product Description <span class="text-danger">*</span> <span
                                    class="tooltips" data-toggle="modal" data-target="#productDescriptionTooltip"><i
                                        class="fa fa-question-circle" aria-hidden="true"></i></span></label>
                            <textarea name="description" id="description" placeholder="Enter Product Description"
                                class="form-control"
                                data-parsley-required-message="Please enter Description.">{{@$row->description}}</textarea>
                        </div>
                    </div>
                   
                </div>
              
                <div class="col-12 up-now">
                    <button type="submit" class="btn btn-danger" id="formDisabled">Save</button>
                </div>
        </div>
        </form>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        {{--Footer--}}
    </div>
    <!-- /.card-footer-->
    </div>
    <!-- /.card -->

</section>

    <!-- Modal -->
    <div class="modal fade" id="productDescriptionTooltip" tabindex="-1" aria-labelledby="productDescriptionTooltipLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    {{-- <div class="modalHeading">
                    </div> --}}
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"><i
                        class="fi fi-sr-cross-small"></i></button>
                    <div class="orderData">
                        <div class="modalProductInfo">
                            <div class="modalProductForm">
                                <p><strong>For a better search in Google and other search engines, your content must be SEO
                                        friendly with following:</strong></p>
                                <ol>
                                    <li class="mb-3">
                                        Description should be written with those aspects in mind in order to rank better.
                                    </li>
                                    <li class="mb-3">
                                        One of the most important aspects of SEO writing is using the proper keywords. This
                                        means knowing what people are searching for when they are looking for sites like
                                        yours. Use your keywords 4 to 5 times (product name)
                                    </li>
                                    <li class="mb-3">
                                        It’s also important to use a lot of related words in the content. That means words
                                        that go well with the keywords that were researched. By adding suffix and prefix
                                        words, it calls "long tale keyword"
                                    </li>
                                    <li class="mb-3">
                                        Highlight your keywords with Bold and Underline
                                    </li>
                                </ol>
                                {{-- 1. Description should be written with those aspects in mind in order to rank better.
                            2. One of the most important aspects of SEO writing is using the proper keywords. This means knowing what people are searching for when they are looking for sites like yours. Use your keywords 4 to 5 times (product name)
                            3. It’s also important to use a lot of related words in the content. That means words that go well with the keywords that were researched. By adding suffix and prefix words, it calls "long tale keyword"
                            4. Highlight your keywords with Bold and Underline  --}}
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <!-- /.content -->
    @endsection
    @section('admin_script_codes')
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
    $('#description').summernote({
        height: 300,
    });
  
    </script>
    @endsection