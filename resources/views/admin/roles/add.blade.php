@extends('admin.layouts.master_admin')

{{config('app.name')}} | Add Role

@section('content')
<style>
         .checkbox label::before {
            margin-left: 0;
            top: -13px;
        }

        .checkbox input[type=checkbox]:checked + label::after {
            left: 25px;
            top: -9px;
        }
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Role</h1>
                </div>

                
            </div>
        </div><!-- /.container-fluid -->
    </section>

 
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body">   
                <form action="" method="post"
                        id="add_business_form" enctype="multipart/form-data" data-parsley-validate>
                    @csrf
                    <fieldset>
                        <div class="form-group">
                            <label for="exampleInputEmail4">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name"
                                    id="name" placeholder="Enter name" required=""  data-parsley-required-message="Please enter name." value="{{old('name')}}">
                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="row">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Permission</th>
                                    <th>All</th>
                                    <th>View</th>
                                    <th>Create</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($permissions as $name => $permission)
                                    <tr>
                                        <td>{{ $name }}</td>
                                        <td>
                                            <div class="checkbox checkbox-primary">
                                                <input id="c{{ $name }}" type="checkbox" class="checkbox-row">
                                                <label for="c{{ $name }}"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="checkbox checkbox-primary">
                                                <input id="c{{ $permission[0]->id }}" type="checkbox"
                                                       value="{{ $permission[0]->name }}"
                                                       class="checkbox-item"
                                                       name="permissions[]"
                                                >
                                                <label for="c{{ $permission[0]->id }}"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="checkbox checkbox-primary">
                                                <input id="c{{ $permission[1]->id }}" type="checkbox"
                                                       value="{{ $permission[1]->name }}"
                                                       class="checkbox-item"
                                                       name="permissions[]"
                                                >
                                                <label for="c{{ $permission[1]->id }}"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="checkbox checkbox-primary">
                                                <input id="c{{ $permission[2]->id }}" type="checkbox"
                                                       value="{{ $permission[2]->name }}"
                                                       class="checkbox-item"
                                                       name="permissions[]"
                                                >
                                                <label for="c{{ $permission[2]->id }}"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="checkbox checkbox-primary">
                                                <input id="c{{ $permission[3]->id }}" type="checkbox"
                                                       value="{{ $permission[3]->name }}"
                                                       class="checkbox-item"
                                                       name="permissions[]"
                                                >
                                                <label for="c{{ $permission[3]->id }}"></label>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @foreach($errors->get('permissions') as $error)
                                <span class="text-danger">{{ $error }}</span>
                            @endforeach
                        </div>
                        <input type="submit" class="btn btn-info" value="Save">

                    </fieldset>
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
    <!-- /.content -->
@endsection

@section('admin_script_codes')
<script>
        $('.checkbox-row').on('change', function () {
            toggleRow($(this));
        });

        $('.checkbox-item').on('change', function () {
            let checked = true;

            $(this).parents('tr').first()
                .children('td')
                .children('div')
                .children('.checkbox-item')
                .each(function (index, el) {
                    if (!$(el).prop('checked')) {
                        checked = false;
                    }
                });

            $(this).parents('tr').first()
                .children('td')
                .children('div')
                .children('.checkbox-row')
                .prop('checked', checked);
        });

        function toggleRow(el) {
            if (el.prop('checked')) {
                el.parents('td').siblings('td').children('div').children('input').prop('checked', true);
            } else {
                el.parents('td').siblings('td').children('div').children('input').prop('checked', false);
            }
        }


    </script>
@endsection
