@extends('backend.layout.app')

@section('content')
    <div class="content-page">
        <div class="content">
            <!-- end row -->
            <div class="row pd">
                <div class="col-md-10" style="margin: 0 auto">
                    <div class="card-box">
                        <h3 class="mt-0 mb-3 text-center">Print Barcode</h3>
                        <div class="row previewBox">
                            @for ($i = 1; $i <= $qty; $i++)
                                <div class="col-4 text-center" style="border:1px dotted black">
                                    <h3>{{ $product->name }}</h3>
                                    <div style="margin: 0 auto">{!! $product->bar_code !!}</div>
                                    <h3 class="text-center bolder">{{ $product->product_code }}</h3>
                                </div>
                            @endfor
                        </div>
                        <div class="row mt-1">
                            <div class="col-4">
                                <button type="submit" class="btn btn-success" id="printBarcode">Print</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection()
    @section('scripts')
        <script type="text/javascript" charset="utf-8" async defer>
            $(document).ready(function() {

                $('#printBarcode').click(function() {
                    $(this).hide()
                    window.print();
                    // $(this).show();
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
