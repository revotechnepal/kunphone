@extends('frontend.layouts.app')
@section('content')

    <section class="ftco-section">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-xl-10 ftco-animate">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('details.submitdetails',['slug' => $product->slug, 'id' => $productstorage->id] )}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <h5 class="mb-4 mt-4 billing-heading text-center">Tell us about your Phone</h5>
                            <div class="row mb-5 align-items-end">
                                <div class="col-md-4">
                                    <div class="aa-input-container" id="aa-input-container">
                                        <div class="form-group">
                                            <label for="makecalls">Able to make calls?</label>
                                            <select class="form-control" name="makecalls" id="userreplaceable">
                                                <option value="yes">Yes</option>
                                                <option value="no">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="aa-input-container" id="aa-input-container">
                                        <div class="form-group">
                                            <label for="phonescreen">Any Problems with your mobile screeen?</label>
                                            <select class="form-control" name="phonescreen" id="userreplaceable">
                                                <option value="yes">Yes</option>
                                                <option value="no">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="aa-input-container" id="aa-input-container">
                                        <div class="form-group">
                                            <label for="bodydefects">Any defects on your phone body?</label>
                                            <select class="form-control" name="bodydefects" id="userreplaceable">
                                                <option value="yes">Yes</option>
                                                <option value="no">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="timeused">Time Used</label>
                                        <div class="row">
                                            <div class="col-md-7">
                                                <input type="text" class="form-control" placeholder="Time in number" name="timeused">
                                                @error('timeused')
                                                    <p class="text-danger">{{$message}}</p>
                                                @enderror
                                            </div>
                                            <div class="col-md-5">
                                                <div class="select-wrap">
                                                    <select name="duration" class="form-control">
                                                        <option value="years">Years</option>
                                                        <option value="months">Months</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="aa-input-container" id="aa-input-container">
                                        <div class="form-group">
                                            <label for="warranty">Is your phone under warranty?</label>
                                            <select class="form-control" name="warranty" id="userreplaceable">
                                                <option value="yes">Yes</option>
                                                <option value="no">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="return">Accessories/Purchase Bill</label>
                                        <select name="return" id="" class="form-control">
                                            <option value="originalcharger">Original Charger</option>
                                            <option value="bill">Purchase Bill</option>
                                            <option value="both">Both</option>
                                            <option value="none">None</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <h5 class="mb-4 billing-heading text-center">Functional or Physical problems</h5>
                            <div class="row mt-2 mb-5">
                                <div class="col-md-4">
                                    <div class="aa-input-container" id="aa-input-container">
                                        <div class="form-group">
                                            <label for="frontcamera">Is front camera working?</label>
                                            <select class="form-control" name="frontcamera">
                                                <option value="yes">Yes</option>
                                                <option value="no">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="aa-input-container" id="aa-input-container">
                                        <div class="form-group">
                                            <label for="backcamera">Is back camera working?</label>
                                            <select class="form-control" name="backcamera">
                                                <option value="yes">Yes</option>
                                                <option value="no">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="aa-input-container" id="aa-input-container">
                                        <div class="form-group">
                                            <label for="volumebuttons">Is volume buttons working?</label>
                                            <select class="form-control" name="volumebuttons">
                                                <option value="yes">Yes</option>
                                                <option value="no">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="aa-input-container" id="aa-input-container">
                                        <div class="form-group">
                                            <label for="touchscreen">Is touch screen working?</label>
                                            <select class="form-control" name="touchscreen">
                                                <option value="yes">Yes</option>
                                                <option value="no">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="aa-input-container" id="aa-input-container">
                                        <div class="form-group">
                                            <label for="battery">Is battery working?</label>
                                            <select class="form-control" name="battery">
                                                <option value="yes">Yes</option>
                                                <option value="no">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="aa-input-container" id="aa-input-container">
                                        <div class="form-group">
                                            <label for="volumesound">Is volume sound working?</label>
                                            <select class="form-control" name="volumesound">
                                                <option value="yes">Yes</option>
                                                <option value="no">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="aa-input-container" id="aa-input-container">
                                        <div class="form-group">
                                            <label for="colorfaded">Is phone body color faded?</label>
                                            <select class="form-control" name="colorfaded">
                                                <option value="yes">Yes</option>
                                                <option value="no">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="aa-input-container" id="aa-input-container">
                                        <div class="form-group">
                                            <label for="powerbutton">Is power button working?</label>
                                            <select class="form-control" name="powerbutton">
                                                <option value="yes">Yes</option>
                                                <option value="no">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="aa-input-container" id="aa-input-container">
                                        <div class="form-group">
                                            <label for="chargingpot">Is charging pot working?</label>
                                            <select class="form-control" name="chargingpot">
                                                <option value="yes">Yes</option>
                                                <option value="no">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h5 class="mb-4 billing-heading text-center">Upload Your Phone's Image</h5>
                            <div class="row mt-2 mb-5">
                                <div class="col-md-6">
                                    <div class="aa-input-container" id="aa-input-container">
                                        <div class="form-group">
                                            <label for="frontimage">Front Side Image</label>
                                            <input type="file" name="frontimage" class="form-control">
                                            @error('frontimage')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="aa-input-container" id="aa-input-container">
                                        <div class="form-group">
                                            <label for="backimage">Back Side Image</label>
                                            <input type="file" name="backimage" class="form-control" placeholder="Phone number">
                                            @error('backimage')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h5 class="mb-4 billing-heading text-center">Personal Details</h5>
                            <div class="row mt-2 mb-5">
                                <div class="col-md-4">
                                    <div class="aa-input-container" id="aa-input-container">
                                        <div class="form-group">
                                            <label for="fullname">Your Full Name</label>
                                            <input type="text" name="fullname" class="form-control" placeholder="Full Name">
                                            @error('fullname')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="aa-input-container" id="aa-input-container">
                                        <div class="form-group">
                                            <label for="phone">Phone no.</label>
                                            <input type="text" name="phone" class="form-control" placeholder="Phone number">
                                            @error('phone')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h5 class="mb-4 billing-heading text-center">Other Defects</h5>
                            <div class="row">
                                <div class="w-100"></div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="otherdefects">Mention any parts changed in your phone.</label>
                                        <textarea name="otherdefects" class="form-control" rows="6" placeholder="Product parts changed details..."></textarea>
                                        @error('otherdefects')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12 text-center">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary py-3 px-4" style="width: 150px; font-size: 14px;">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
              <!-- END -->
	        </div>
        </div> <!-- .col-md-8 -->
    </div>
    </section> <!-- .section -->

@endsection

