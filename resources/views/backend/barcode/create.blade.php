@extends('backend.layout.app')
@section('content')
    <div class="content-page">
        <div class="content">
            <!-- end row -->
            <div class="row first">
                <div class="col-md-12">
                    <div class="card-box">
                        <h2 class="mt-0 mb-3">Bar Code</h2>
                        @if (Session::has('success'))
                            <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <strong>Success!</strong> <span>{{ Session::get('success') }}</span>

                            </div>
                        @endif
                        <form role="form"
                            action={{ isset($category) ? "{{ route('category.update', $category->id) }}" : "{{ route('order.store') }}" }}
                            method="post">
                            @if (isset($category))
                                @method('PUT')
                            @endif

                            @csrf

                            <!-- Form row -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" id="rows bg-info" style="box-shadow: 0 25px 35px 0 lightgrey">

                                        <table class="table table-bordered table-striped table-responsive" id="user_table">
                                            <thead>
                                                <tr>
                                                    <th width="50%">Products</th>
                                                    <th width="25%">Quantity</th>
                                                    <th width="25%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="2" align="right">&nbsp;</td>
                                                    <td>

                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                                {{-- end of col --}}
                            </div>
                            <!-- end row -->
                            <div class="row">
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-6">
                                            <button type="submit" id="preview"
                                                class="btn btn-primary btn-block">Preview</button>
                                        </div>
                                        <div class="col-6">
                                            <button type="submit" id="showB"
                                                class="btn btn-success btn-block">Go To Barcode</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
            <div class="row pd" style="display: none">
                <div class="col-md-10" style="margin: 0 auto">
                    <div class="card-box">
                        <h3 class="mt-0 mb-3 text-center">Preview</h3>
                        <div class="row previewBox">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection()
    @section('scripts')
        <script type="text/javascript" charset="utf-8" async defer>
            $(document).ready(function() {
                html = '';

                dynamic_field();

                function add_select() {

                    $('body').find('#products').select2();
                }

                function dynamic_field() {

                    html = '<tr>';
                    html += `<td> 
                          <select name="products[]" id="products" class="form-control pid" >
                            <option value="" readonly>Chose Product</option>
                            {!! \App\Http\Controllers\OrderController::fetch_products() !!}
                          </select>
                          </td>`
                    html +=
                        `<td>
                          <input type="number" name="quantity[]" class="form-control qty" />
                          </td>`;

                    // $('#products:last').select2();

                    html +=
                        '<td><button type="button" name="remove" id="" class="btn btn-danger remove">Remove</button></td></tr>';
                    // $('#products:last').select2();

                    $('tbody').append(html);

                    add_select();
                }

                $(document).on('click', '#preview', function(e) {
                    e.preventDefault();
                    let qty = $('.qty').val();
                    let id = $('.pid').val();
                    $('.pd').css("display", "block");


                    $.ajax({
                        url: "{{ route('barcode.product') }}",
                        method: "post",
                        data: {
                            "id": id,
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType: "json",
                        success: function(response) {
                            $('.previewBox').html('');
                            let html =
                                "<div class='col-4 text-center' style='border:1px dotted black'>"
                            html += "<h3>" + response.name + "</h3>"
                            html += "<div style='margin: 0 auto'> " + response.bar_code + " </div>"
                            html += "<h3 class'text-center bolder'>" + response.product_code + "</h3>"
                            html += "</div>";

                            for (let i = 1; i <= qty; i++) {
                                $('.previewBox').append(html);
                            }

                        }
                    });

                });

                $(document).on('click', '#showB', function(e) {
                    e.preventDefault();
                    let qty = $('.qty').val();
                    let id = $('.pid').val();

                    window.location.href = window.location.href = "/barcode/print?qty=" + qty + "&id=" + id;

                });

                $(document).on('click', '.remove', function() {

                    $(this).closest("tr").remove();
                });

                $('tbody').delegate('.pid', 'change', function() {
                    // dynamic_field();
                    var id = $(this).val();
                    // var tr = $(this).parent().parent();

                    $.ajax({
                        url: "{{ route('barcode.product') }}",
                        method: "post",
                        data: {
                            "id": id,
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType: "json",
                        success: function(response) {
                            $('.qty').val(1);
                        }
                    });
                });

                $('tbody').on('change', '.qty', function() {
                    var qty = $(this).val();
                    if (isNaN(qty)) {
                        alert('Please Select a valid quantity');
                        $(this).val(1);

                    } else {
                        if (qty <= 0) {
                            $(this).val(1);
                        }
                    }
                });
            });
        </script>
    @endsection
