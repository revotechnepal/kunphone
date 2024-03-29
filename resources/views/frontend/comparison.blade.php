@extends('frontend.layouts.app')
@push('styles')
    <!-- Algolia Search -->
    <link rel="stylesheet" href="{{ asset('frontend/css/algolia.css') }}">
@endpush
@section('content')

    @if (session('error'))
        <div class="row">
            <div class="col-sm-4 ml-auto message scroll">
                <div class="alert  alert-success alert-dismissible fade show" role="alert" style="background: darkred; color: white;">
                {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
    <section class="ftco-section">
        <div class="container">
            <h3 class="billing-heading text-center mb-5">Compare your Phones</h3>
            <div class="row">
                <div class="col-md-2 text-center">
                    Your Phones to Compare
                </div>
                <div class="col-md-10">
                    <form action="{{route('comparephone')}}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-md-5">
                                <div class="aa-input-container" id="aa-input-container">
                                    <input type="search" id="aa-search-input" class="aa-input-search" placeholder="Search your phone" name="product1"
                                        autocomplete="off" required/>
                                    <svg class="aa-input-icon" viewBox="654 -372 1664 1664">
                                        <path d="M1806,332c0-123.3-43.8-228.8-131.5-316.5C1586.8-72.2,1481.3-116,1358-116s-228.8,43.8-316.5,131.5  C953.8,103.2,910,208.7,910,332s43.8,228.8,131.5,316.5C1129.2,736.2,1234.7,780,1358,780s228.8-43.8,316.5-131.5  C1762.2,560.8,1806,455.3,1806,332z M2318,1164c0,34.7-12.7,64.7-38,90s-55.3,38-90,38c-36,0-66-12.7-90-38l-343-342  c-119.3,82.7-252.3,124-399,124c-95.3,0-186.5-18.5-273.5-55.5s-162-87-225-150s-113-138-150-225S654,427.3,654,332  s18.5-186.5,55.5-273.5s87-162,150-225s138-113,225-150S1262.7-372,1358-372s186.5,18.5,273.5,55.5s162,87,225,150s113,138,150,225  S2062,236.7,2062,332c0,146.7-41.3,279.7-124,399l343,343C2305.7,1098.7,2318,1128.7,2318,1164z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="aa-input-container" id="aa-input-container">
                                    <input type="search" id="aa-search-input1" class="aa-input-search" placeholder="Search your phone" name="product2"
                                        autocomplete="off" required/>
                                    <svg class="aa-input-icon" viewBox="654 -372 1664 1664">
                                        <path d="M1806,332c0-123.3-43.8-228.8-131.5-316.5C1586.8-72.2,1481.3-116,1358-116s-228.8,43.8-316.5,131.5  C953.8,103.2,910,208.7,910,332s43.8,228.8,131.5,316.5C1129.2,736.2,1234.7,780,1358,780s228.8-43.8,316.5-131.5  C1762.2,560.8,1806,455.3,1806,332z M2318,1164c0,34.7-12.7,64.7-38,90s-55.3,38-90,38c-36,0-66-12.7-90-38l-343-342  c-119.3,82.7-252.3,124-399,124c-95.3,0-186.5-18.5-273.5-55.5s-162-87-225-150s-113-138-150-225S654,427.3,654,332  s18.5-186.5,55.5-273.5s87-162,150-225s138-113,225-150S1262.7-372,1358-372s186.5,18.5,273.5,55.5s162,87,225,150s113,138,150,225  S2062,236.7,2062,332c0,146.7-41.3,279.7-124,399l343,343C2305.7,1098.7,2318,1128.7,2318,1164z" />
                                    </svg>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-dark">Start comparing</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
<script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
<script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
<script src="{{ asset('frontend/js/algolia_phone1.js') }}"></script>
@endpush

