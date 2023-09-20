<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserCertificate;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\StripeAccount;
use App\Models\UserMembershipPlan;
use App\Models\ShipperRfq;
use App\Models\ShipperRfqImage;
use App\Models\ShipperRfqDocument;
use App\Models\ShipperRfqRequest;
use App\Models\ShipperRfqResponse;
use App\Models\AuctionLot;
use App\Models\AuctionBid;
use App\Models\AuctionImage;
use App\Models\QbWebhook;
use App\Models\SeoContent;
use Auth;
use Hash;
use File;
use DB;
use Str;
use Stripe;
use App\Models\AdminCommission;
use App\Models\Rfq;
use App\Models\FavoriteProduct;
use App\Models\FavoriteShipper;
use App\Models\RatingReviewProduct;
use App\Models\RatingReviewShipper;
use App\Models\RatingReviewSeller;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\SellerRfqRespond;
use App\Models\ChatMessage;
use App\Imports\SellerProductsImport;
use Maatwebsite\Excel\Facades\Excel;
use Newsletter;
use Mail;
use App\Notifications\PasswordChanged; 
use App\Notifications\RfqToSellers; 
use App\Notifications\ProductReviewRatingNotification;
use App\Notifications\ShipperReviewRatingNotification;
use App\Notifications\SellerReviewRatingNotification;
use App\Notifications\OrderStatusChangedNotification;
use App\Notifications\RfqStatusChangedNotification;
use App\Notifications\RfqRespondNotification;
use App\Notifications\BidPlacedNotification;
use App\Notifications\BuyerContactAdmin;
use App\Notifications\QuotationRejection;
use Session;
use Carbon\Carbon;
use App\Models\Company;
use App\Models\ShippingMethod;
use App\Models\SubscriptionPlan;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Models\NmfcCode;
use App\Models\UserCred;
use App\Models\RfqProducts;
use App\Models\State;
use App\Models\UserInquiry;
use App\Notifications\InquiryFromBuyerNotification;
use App\Notifications\InquiryReplyFromSellerNotification;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function changePassword(request $request)
    {
        $user = User::find(Auth::id());

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Sorry your current password does not match.!')->withInput();
        }

        $this->validate($request, 
        [
            'password' => 'required|confirmed|min:8'
        ],[
            'password.min' => 'Please enter password at least 8 characters long'
        ]
    );

        if ($request->password == $request->password_confirmation) {
            if ($user) {
                $password_updated = $user->update(['password' => Hash::make($request->password)]);

                if ($password_updated) {
                    $user->notify(new PasswordChanged($user));
                    return back()->with(['success' => 'Password is changed successfully.!']);
                } else {
                    return back()->with(['error' => 'There is an error while changing the password please try again later.!']);
                }
            }
        } else {
            return back()->with('error', 'New password do not matched with confirm password.!')->withInput();
        }
    }
    
    public function myProfile()
    {
            return view('front-user.my-profile');
    }

    public function updateProfile(Request $request)
    {
        $formData = request()->except(['_token']);

        if ($request->hasFile('profile_pic')) {
            $allowedfileExtension = ['jpeg', 'jpg', 'png', 'svg'];
            $file = $request->file('profile_pic');
            File::delete(Auth::user()->profile_pic);

            $extension = $file->getClientOriginalExtension();

            if (in_array($extension, $allowedfileExtension)) {

                $formData['profile_pic'] = $file->store('profile_pics');
            }else{
                return back()->with('error', 'Please select image for profile picture !')->withInput();
            }
        }

        

       
       $user = User::find(Auth::id())->update($formData);

        return back()->with('success', 'Profile updated successfully');

    }

    public function subscribeNewsletter(Request $request)
    {
        //    dd($request->all());

            // if($request->first_name!='')
            // {
            //     $name = explode(' ', $request->first_name);
            //     $fname = $name[0];
            //     if(isset($name[1]))
            //         $lname = $name[1];
            //     else
            //         $lname = '';
            // }
            // else
            // {
            //     $fname = '';
            //     $lname = '';
            // }

            // $arr = [
            //     'properties' => [
            //         [
            //             'property' => 'firstname',
            //             'value' => $fname,
            //         ],
            //         [
            //             'property' => 'lastname',
            //             'value' =>  $lname,
            //         ],
            //         [
            //             'property' => 'phone',
            //             'value' =>  $request->phone,
            //         ],
            //         [
            //             'property' => 'email',
            //             'value' =>  $request->email,
            //         ],
            //         [
            //             'property' => 'jobtitle',
            //             'value' => isset($request->jobtitle)?$request->jobtitle:''
            //         ],
            //     ]
            // ];

        // $hubspot = \HubSpot\Factory::createWithAccessToken(config('settings.env.HUBSPOT_API_KEY'));
        // $contactInput = new \HubSpot\Client\Crm\Contacts\Model\SimplePublicObjectInput();
        // $contactInput->setProperties([
        //     'email' => $request->email
        // ]);
        // $filter = new \HubSpot\Client\Crm\Contacts\Model\Filter();
        // $filter
        //     ->setOperator('EQ')
        //     ->setPropertyName('email')
        //     ->setValue($request->email);
        
        // $filterGroup = new \HubSpot\Client\Crm\Contacts\Model\FilterGroup();
        // $filterGroup->setFilters([$filter]);
        
        // $searchRequest = new \HubSpot\Client\Crm\Contacts\Model\PublicObjectSearchRequest();
        // $searchRequest->setFilterGroups([$filterGroup]);
        
        // // @var CollectionResponseWithTotalSimplePublicObject $contactsPage
        // $contactsPage = $hubspot->crm()->contacts()->searchApi()->doSearch($searchRequest);
        // // dd($contactsPage);
        // if($contactsPage['total'] === 0)
        // {
        //     $contact = $hubspot->crm()->contacts()->basicApi()->create($contactInput);
            
        //     $data = array('subscribe' => 1,'name'=>$request->first_name, 'email'=>$request->email, 'vid'=>$contact['id']);

        //     Mail::send('front-user.email.newsletter-subscribed', ['data'=>$data], function($message) use ($data){
        //                 $message->to( $data['email']);
        //                 $message->subject(config('app.name')." - Newsletter subscribed successfully");
        //             });

        // $user =  Auth::user();

        // $user->vid = $contact['id'];
        // $user->save();
        $request->name =  $request->first_name .' '. $request->last_name;
        if($request->name!='')
        {
            $name = explode(' ', $request->name);
            $fname = $name[0];
            if(isset($name[1]))
                $lname = $name[1];
            else
                $lname = '';
        }
        else
        {
            $fname = '';
            $lname = '';
        }

        if (Newsletter::isSubscribed($request->email) == false) {
            Newsletter::subscribeOrUpdate($request->email,['FNAME'=>$fname, 'LNAME'=>$lname]);
            if(Auth::user()->user_type == 'buyer')
            {
                $type = ['Buyer'];
            }elseif(Auth::user()->user_type == 'shipper'){
                $type = ['Shipper'];
            }else{
                $type = ['Seller'];
            }
            
            Newsletter::addTags($type, $request->email);
            $data = array('subscribe' => 1,'name'=>$request->name, 'email'=>$request->email, 'subscribe'=>1);

            Mail::send('front-user.email.newsletter-subscribed', ['data'=>$data], function($message) use ($data){
                $message->to( $data['email']);
                $message->subject(config('app.name')." - Newsletter subscribed successfully");
            });
            
            return $msg = 'Newsletter subscribed successfully.';
        }
        else
        {
            return  $msg = 'Newsletter already subscribed.';
        }
    }

    public function unsubscribeNewsletter($email)
    {

        // $email = base64_decode($email);
        // $vid = base64_decode($vid);
       
        // $hubspot = \HubSpot\Factory::createWithAccessToken(config('settings.env.HUBSPOT_API_KEY'));
        // $hubspot->crm()->contacts()->basicApi()->archive($vid);

        // $data = array('unsubscribe' => 1,'email'=>$email);

        // $user = User::whereEmail($email)->first();
        // $user->is_newsletter_subscribe = false;
        // $user->save();
        
        // Mail::send('front-user.email.newsletter-subscribed', ['data'=>$data], function($message) use ($data){
        //     $message->to( $data['email']);
        //     $message->subject("Newsletter unsubscribed successfully");
        // });

        // $email = base64_decode($email);
        if ( Newsletter::isSubscribed($email) ) {
            Newsletter::unsubscribe($email);
        }
        $data = array('unsubscribe' => 1,'email'=>$email);

        Mail::send('front-user.email.newsletter-subscribed', ['data'=>$data], function($message) use ($data){
            $message->to( $data['email']);
            $message->subject(config('app.name')." - Newsletter unsubscribed successfully");
        });

        return $msg = 'You have successfully unsubscribed.';
    }
    public function notifications($value='')
    {
        DB::table('notifications')->where('read_at', NULL)->where('notifiable_id', Auth::id())->update(['read_at' => Date('Y-m-d H:i:s')]);

        $all_notifications = Auth::user()->notifications()->paginate(10);
        $notifications = [];
        foreach ($all_notifications as $notification) {
            $notifications[] = $notification;
        }

        return view('front-user.notifications', compact('notifications'));
    }



    public function manageProducts()
    { 
        $membershipProduct = UserMembershipPlan::where('user_id', Auth::id())->whereStatus('Active')->first(); 
        $products = Product::leftjoin('product_categories', 'product_categories.id', '=', 'products.category_id')
                    ->leftjoin('featured_products', 'featured_products.product_id', '=', 'products.id')
                    ->select('products.*','product_categories.name as category_name','featured_products.id as featured')
                    ->where(function($q){
                        $q->where('products.user_id', Auth::id())->orWhere('products.user_id', Auth::user()->parent_id);
                    })->orWhereHas('user', function($q){
                            $q->where('parent_id', Auth::id());
                    })
                    ->where('products.rfq', 'null')
                    ->orderBy('id','desc')->paginate(20);

        $category = ProductCategory::get();
        $companies = Company::whereStatus(1)->orderBy('name', 'ASC')->get();
        $nmfcCodes = NmfcCode::orderBy('nmfc_code', 'ASC')->get();

        return view('front-user.products-management', compact('products','category','companies','nmfcCodes','membershipProduct')); 
 
    } 
    public function saveProducts(Request $request)
    {   
        $formData = request()->except(['_token', 'new_nmfc_code', 'meta_title', 'meta_description', 'meta_keywords']);  
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'], 
            // 'images' => ['mimes:jpeg,jpg,png,svg,mov,mp4,webm,mkv'], 
        ], [
            "name.required" => "Please enter :attribute", 
            "images.mimes" => "Please enter valid product image", 
        ]);
        $formData['user_id'] = Auth::id(); 
        $nmfc_code = null;
        if( isset($request->nmfc_code) && $request->nmfc_code == 'other' && isset($request->new_nmfc_code) && $request->new_nmfc_code != null)
        {
            $nmfcExist = NmfcCode::whereNmfcCode($request->new_nmfc_code)->first();
            if(! $nmfcExist){
                $nmfc = NmfcCode::create([
                    'nmfc_code' => $request->new_nmfc_code
                ]);
    
                $formData['nmfc_code']  = $nmfc->nmfc_code;
            }else{
                $formData['nmfc_code']  = $nmfcExist->nmfc_code;
            }
          
        }elseif(isset($request->nmfc_code)){
            $formData['nmfc_code']  = $request->nmfc_code;
        }

        if(isset($request->company_id) && $request->company_id != 'other')
        {
            $company = Company::whereName($request->company_id)->first();
            
            if($company){
                $formData['company_id'] = $company->id;
            }
        }

        if(isset($request->new_company_name))
        {
            $companyExist = Company::whereName($request->new_company_name)->first();

            if(! $companyExist){
                $company = Company::create([
                    'name' => $request->new_company_name,
                    'size' => $request->company_size,
                    'revenue' => $request->revenue,
                ]);

                $formData['company_id'] = $company->id;
            }else{
                $formData['company_id'] = $companyExist->id;
            }
        }

        if ($request->hasFile('specification')) {
            $allowedfileExtension = ['jpeg', 'jpg', 'png', 'svg'];
            $file = $request->file('specification');

            $extension = $file->getClientOriginalExtension();

            if (in_array($extension, $allowedfileExtension)) {

                $formData['specification'] = $file->store('specifications');
            }else{
                return back()->with('error', 'Please select only image for specification !')->withInput();
            }
        }
        
        $uploadedMedias=''; 
        if($request->hasfile('images')){
            foreach($request->file('images') as $file){

                if($file != ''){
                    $allowedfileExtension = ['jpeg', 'jpg', 'png', 'svg', 'JPG', 'PNG', 'JPEG', 'SVG', 'MOV', 'MP4', 'webm', 'mkv', 'mp4']; 
                    $extension = $file->getClientOriginalExtension(); 
                    if (in_array($extension, $allowedfileExtension)) { 
                        $name = "prod".str_random(5).time().'.'.$file->extension();
                        $file->move(public_path().'/storage/app/product-images/', $name);
                        $uploadedMedias .= "product-images/".$name.",";
                    }else{
                        return back()->with('error', 'Please select only image or videos for product images/videos !')->withInput();
                    }
                }
            }
        }
        $formData['images'] = substr_replace($uploadedMedias,'',-1); 

        // if ($request->hasFile('images')) {
        //     $allowedfileExtension = ['jpeg', 'jpg', 'png', 'svg', 'JPG', 'PNG', 'JPEG', 'SVG'];
        //     $file = $request->file('images'); 
        //     $extension = $file->getClientOriginalExtension(); 
        //     if (in_array($extension, $allowedfileExtension)) { 
        //         $formData['images'] = $file->store('product-images');
        //     }
        // } 

        if($request->product_type == '' ){  
            $formData['product_type'] = 'used';
        }

        if(isset($formData['category_id'])){
            $formData['category_id'] = implode(',', $formData['category_id']);
        }

        $formData['bid_date'] = carbon::now()->addDays($formData['bid_days'] + 1);

        $Product = Product::create($formData); 

        if($request->buying_format == 'Auction')
        {
            AuctionLot::create([
                'lot_name' => $Product->name,
                'user_id' => Auth::user()->id,
                'product_ids' => $Product->id,
                'location' => $Product->location,
                'description' => $Product->description,
                'specification' => isset($formData['specification']) ? $formData['specification'] : '',
                'lead_time' => $Product->lead_time,
                'price' => $Product->price,
                'bid_increment' => $Product->bid_increment,
                'start_bid' => $Product->start_bid,
                'bid_qty' => $Product->bid_qty,
                'bid_days' => $Product->bid_days,
                'bid_date' => $Product->bid_date,
                'country' => $Product->country,
                'state' => $Product->state,
            ]);
        }

        $url = url('product-detail', $Product->id);

        if($request->meta_title){
            SeoContent::create([
                'title' =>$request->meta_title,
                'description' => $request->meta_description,
                'keywords' => $request->meta_keywords,
                'route' => $url
            ]);
        }
    
        if ($Product->save()) {
            return redirect('/products-management')->with('success', 'Product   added successfully.');
        } else {
            return redirect('/products-management')->with('error', 'Sorry there is an error while adding Product. please try again.')->withInput();
        }   
    }


    public function editProduct($id)
    {
        $row = Product::leftjoin('product_categories', 'product_categories.id', '=', 'products.category_id')
                    ->select('products.*','product_categories.name as category_name')
                    ->where('products.id', $id)
                    ->first();
        $category = ProductCategory::get();
        $companies = Company::whereStatus(1)->orderBy('name', 'ASC')->get();
        $nmfcCodes = NmfcCode::orderBy('nmfc_code', 'ASC')->get();
        $url = url('product-detail', $id);
        $seo = SeoContent::whereRoute($url)->first();

        return view('front-user.products-edit', compact('row','category', 'companies', 'nmfcCodes','seo'));
    }

    public function updateProduct($id, Request $request)
    {
        $formData = request()->except(['_token', 'new_nmfc_code', 'meta_title', 'meta_description', 'meta_keywords']);  
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'], 
            // 'images' => ['mimes:jpeg,jpg,png,svg,mov,mp4,webm,mkv'], 
        ], [
            "name.required" => "Please enter :attribute", 
            "images.mimes" => "Please enter valid product image", 
        ]);
    
        $formData['user_id'] = Auth::user()->id; 
        $nmfc_code = null;
        if( isset($request->nmfc_code) && $request->nmfc_code == 'other' && isset($request->new_nmfc_code) && $request->new_nmfc_code != null)
        {
            $nmfcExist = NmfcCode::whereNmfcCode($request->new_nmfc_code)->first();
            if(! $nmfcExist){
                $nmfc = NmfcCode::create([
                    'nmfc_code' => $request->new_nmfc_code
                ]);
    
                $formData['nmfc_code']  = $nmfc->nmfc_code;
            }else{
                $formData['nmfc_code']  = $nmfcExist->nmfc_code;
            }
        }elseif(isset($request->nmfc_code)){
            $formData['nmfc_code']  = $request->nmfc_code;
        }

        if(isset($request->company_id) && $request->company_id != 'other')
        {
            $company = Company::whereName($request->company_id)->first();
            
            if($company){
                $formData['company_id'] = $company->id;
            }
        }

        if(isset($request->new_company_name))
        {
            $companyExist = Company::whereName($request->new_company_name)->first();

            if(! $companyExist){
                $company = Company::create([
                    'name' => $request->new_company_name,
                    'size' => $request->company_size,
                    'revenue' => $request->revenue,
                ]);

                $formData['company_id'] = $company->id;
            }else{
                $formData['company_id'] = $companyExist->id;
            }
        }


        // if ($request->hasFile('images')) {
        //     $allowedfileExtension = ['jpeg', 'jpg', 'png', 'svg', 'JPG', 'PNG', 'JPEG', 'SVG'];
        //     $file = $request->file('images'); 
        //     $extension = $file->getClientOriginalExtension(); 
        //     if (in_array($extension, $allowedfileExtension)) { 
        //         $formData['images'] = $file->store('product-images');
        //     }
        // }

          // save the row to the database
          $duplicateEntry = Product::whereName($formData['name'])->first();
        if ($request->hasFile('specification')) {
            $allowedfileExtension = ['jpeg', 'jpg', 'png', 'svg'];
            $file = $request->file('specification');
            File::delete($duplicateEntry->specification);

            $extension = $file->getClientOriginalExtension();

            if (in_array($extension, $allowedfileExtension)) {

                $formData['specification'] = $file->store('specifications');
            }else{
                return back()->with('error', 'Please select only image for specification !')->withInput();
            }
        }
        
        $uploadedMedias=''; 
        if($request->hasfile('images')){
            foreach($request->file('images') as $file){
                if($file != ''){
                    $allowedfileExtension = ['jpeg', 'jpg', 'png', 'svg', 'JPG', 'PNG', 'JPEG', 'SVG', 'mov', 'mp4', 'webm', 'mkv', 'MP4']; 
                    $extension = $file->getClientOriginalExtension(); 
                    if (in_array($extension, $allowedfileExtension)) { 
                        $name = "prod".str_random(5).time().'.'.$file->extension();
                        $file->move(public_path().'/storage/app/product-images/', $name);
                        $uploadedMedias .= "product-images/".$name.",";
                    }else{
                        return back()->with('error', 'Please select only image or videos for product images/videos !')->withInput();
                    }
                }
            }
        }
        $formData['images'] = substr_replace($uploadedMedias,'',-1);

        
        if ($request->buy_america_compliant != 'yes') {
            $formData['buy_america_compliant'] = '';
        }

        if ($request->product_type != 'new') {
            $formData['product_type'] = '';
        }

        if (! isset($request->is_freight_included)) {
            $formData['is_freight_included'] = 0;
        }

        if(isset($formData['category_id'])){
            $formData['category_id'] = implode(',', $formData['category_id']);
        }

        if (! isset($request->is_rfq)) {
            $formData['is_rfq'] = 0;
        }
        // if ($duplicateEntry == '' || ($duplicateEntry != '' && $duplicateEntry->id == $id)) {
            $product = Product::find($id);

            if($product->images != null)
            {
                $images = explode(',', $product->images);
                if($formData['images'] != ''){
                    $newImages = explode(',', $formData['images'] );
               
                    $mergeImage =  array_merge($images, $newImages);

                    $formData['images'] = implode(',', $mergeImage);
                }else{
                    $formData['images'] = $product->images;
                }
            }
            
            if($product->bid_days != $formData['bid_days']){
                $days = $formData['bid_days'] - $product->bid_days ;

                $formData['bid_date'] = Carbon::parse($product->bid_date)->addDays($days + 1);
            }


            $product->update($formData);

            $url = url('product-detail', $product->id);
            $seo = SeoContent::whereRoute($url)->first();
          
            if($seo)
            {
                $seo->update([
                    'title' =>$request->meta_title,
                    'description' => $request->meta_description,
                    'keywords' => $request->meta_keywords
                ]);
            }else{
                if($request->meta_title){
                    SeoContent::create([
                        'title' =>$request->meta_title,
                        'description' => $request->meta_description,
                        'keywords' => $request->meta_keywords,
                        'route' => $url
                    ]);
                }
            }
            if($request->buying_format == 'Auction')
            {
                $auctionLot = AuctionLot::whereProductIds($product->id)->first();

                if($auctionLot){
                    $auctionLot->update([
                        'lot_name' => $product->name,
                        'user_id' => Auth::user()->id,
                        'product_ids' => $product->id,
                        'location' => $product->location,
                        'description' => $product->description,
                        'specification' => $product->specification,
                        'lead_time' => $product->lead_time,
                        'price' => $product->price,
                        'bid_increment' => $product->bid_increment,
                        'start_bid' => $product->start_bid,
                        'bid_qty' => $product->bid_qty,
                        'bid_days' => $product->bid_days,
                        'bid_date' => $product->bid_date,
                        'country' => $product->country,
                        'state' => $product->state,
                    ]);
                }else{
                    AuctionLot::create([
                        'lot_name' => $product->name,
                        'user_id' => Auth::id(),
                        'product_ids' => $product->id,
                        'location' => $product->location,
                        'description' => $product->description,
                        'specification' => $product->specification,
                        'lead_time' => $product->lead_time,
                        'price' => $product->price,
                        'bid_increment' => $product->bid_increment,
                        'start_bid' => $product->start_bid,
                        'bid_qty' => $product->bid_qty,
                        'bid_days' => $product->bid_days,
                        'bid_date' => $product->bid_date,
                        'country' => $product->country,
                        'state' => $product->state,
                    ]);
                }
            }
        // } else
        //     return redirect()->back()->with('error', 'Product name already taken.');

        return redirect('/products-management')->with('success', 'Product updated successfully.');
    }

    public function deleteProduct(Request $request)
    {
        $id = $request->input('id'); 
        $orderCount = OrderProduct::whereProductId($id)->whereIn('status', ['pending', 'Dispatched', 'On the way'])->count();
            
        $rfqCount = Rfq::whereHas('products', function($q)use($id){
            $q->whereId($id)->whereIn('status', ['Packed', 'Dispatched for Shipping', 'On the Way']);
        })->count();
        $shipperRfqCount = ShipperRfqResponse::whereProductId($id)->whereIn('status', ['Packed', 'Dispatched for Shipping', 'On the Way'])->count();
        // dd($orderCount > 0 || $rfqCount > 0 || $shipperRfqCount > 0);
        if($orderCount > 0 || $rfqCount > 0 || $shipperRfqCount > 0){
            $msg = 'Some products are not deleted as procurement process is not completed.';
            return response()->json(['status' => 'error', 'msg' => 'Sorry there is an error in deleting Product as procurement process is not completed. Please try again later!']);
        }else{
            Product::where('id', $id)->delete();
            return response()->json(['status' => 'success', 'msg' => 'You have successfully deleted Product']);
        }
    }

    public function deleteProductImage(Request $request)
    {
        $product = Product::find($request->id);

        if($product)
        {
            $images = explode(',', str_replace(' ', '', $product->images));

            // if(in_array($request->image, $images))
            // {
            //     unset($request->image);

            //     $product->images = implode(',', $images);
            //     $product->save();
            // }

           foreach($images as $key => $image)
           {
            if($image == $request->image){
                unset($images[$key]);
               
                $product->images = implode(',', $images);
                $product->save();
            }
           }

           return response([
            'status' => true,
            'msg' => 'Image deleted successfully.'
           ]);
        }else{
            return response([
                'status' => false,
                'msg' => 'Something went wrong'
               ]);
        }
      
    }

    public function paymentSetup()
    {   
        $stripeAccount = StripeAccount::where('user_id', Auth::id())->first();
        return view('front-user.payment-setup', compact('stripeAccount'));
    }
    
    public function paymentSetupSave(Request $request)
    {
        $account_holder_name = $account_holder_type = $routing_number = $account_number = '';
        $account_holder_name = $_POST['account_holder_name'];
        $account_holder_type = $_POST['account_holder_type'];
        $routing_number = $_POST['routing_number'];
        $account_number = $_POST['account_number']; 
        try { 
             Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            $bank_token = \Stripe\Token::create(array(
                "bank_account" => array(
                    "country" => "US",
                    "currency" => "USD",
                    "account_holder_name" => $account_holder_name,
                    "account_holder_type" => $account_holder_type,
                    "routing_number" => $routing_number,
                    "account_number" => $account_number
               )
            ));
        } catch(\Stripe\Exception\CardException $e) {
            return back()->with('error',$e->getMessage())->withInput();
        } catch (\Stripe\Exception\RateLimitException $e) {
            return back()->with('error',$e->getMessage())->withInput();
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            return back()->with('error',$e->getMessage())->withInput();
        } catch (\Stripe\Exception\AuthenticationException $e) {
            return back()->with('error',$e->getMessage())->withInput();
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            return back()->with('error',$e->getMessage())->withInput();
        }catch (\Stripe\Exception\UnexpectedValueException $e){
            return back()->with('error',$e->getMessage())->withInput();
        } catch (Exception $e) {
            return back()->with('error',$e->getMessage())->withInput();
        }
                // dd($bank_token);
            // $b_token = $bank_token->__toJSON();
            // $obj_token = json_decode($b_token, TRUE);
            
            $b_tok = $bank_token->id;
            $bank_account_id = $bank_token['bank_account']['id'];
            $_SESSION['bankaccid'] = $bank_account_id;
            
            $sp = \Stripe\Customer::create(array(
              "source" => $b_tok,
              "description" => $account_holder_name
            ));
            
            // $customer_json = $sp->__toJSON();
            // $obj = json_decode($customer_json, TRUE);
            $cust_id =  $sp['id'];
            
            $_SESSION['custid'] = $cust_id;
 
            $userPayment_setup = StripeAccount::create([
              'user_id' => Auth::user()->id,
              'stripe_user_id' => $sp->id,
              'stripe_publishable_key' => $sp->default_source
            ]);

            if($sp)
            {
                return  redirect('payment-setup')->with('success', 'Your Bank Account has been connected successfully.'); 
            }               
        

    }
    public function connectStripeAccount(Request $request)
    {
        $tokendata = [
          'client_secret' => 'sk_test_51LHkDAHTgc5iTKHUFq1IhvOva32iAWMZAaMCILYA3Ou1OJvpgiIaoiWftTdGpqRd0cGH19t5givzlfJw8ooY5YJU00cJmaoC6R',
          'code' => $request->code,
          'grant_type' => 'authorization_code',
        ];

        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL =>'https://connect.stripe.com/oauth/token',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30000,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => json_encode($tokendata),
          CURLOPT_HTTPHEADER => array(
            "accept: */*",
            "accept-language: en-US,en;q=0.8",
            "content-type: application/json",
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
          if ($userAccountDtail = json_decode($response)) {
            // print_r($userAccountDtail);exit();
            if(isset($userAccountDtail->error))
            {
              return  redirect('payment-setup')->with('error', 'Something went wrong. Please try again.')->withInput();
            }
            $userPayment_setup = StripeAccount::create([
              'user_id' => Auth::user()->id,
              'stripe_user_id' => $userAccountDtail->stripe_user_id,
              'stripe_publishable_key' => $userAccountDtail->stripe_publishable_key
            ]);

            if ($userPayment_setup) {
              return  redirect('payment-setup')->with('success', 'Your stripe account has been connected successfully.');
            }
          }
        }
    } 

  public function favorites()
  {
    $favProducts = FavoriteProduct::leftjoin('rating_review_products', 'rating_review_products.product_id', '=', 'favorite_products.product_id' )
                ->select('favorite_products.*',DB::raw('(AVG(rating_review_products.rating)) AS average_rating'), DB::raw('COUNT(rating_review_products.id) AS total_rating' ))
                ->where('favorite_products.user_id' , Auth::id())->whereNull('favorite_products.seller_id')
                ->groupBy('favorite_products.product_id')
                ->get();

    $favSellers = FavoriteProduct::leftjoin('rating_review_sellers', 'rating_review_sellers.seller_id', '=', 'favorite_products.seller_id' )
    ->select('favorite_products.*',DB::raw('(AVG(rating_review_sellers.rating)) AS average_rating'), DB::raw('COUNT(rating_review_sellers.id) AS total_rating' ))
    ->where('favorite_products.user_id' , Auth::id())
    ->whereNull('favorite_products.product_id')
    ->groupBy('favorite_products.seller_id')
    ->get();

    $favShippers = FavoriteShipper::leftjoin('rating_review_shippers', 'rating_review_shippers.shipper_id', '=', 'favorite_shippers.shipper_id' )
    ->select('favorite_shippers.*',DB::raw('(AVG(rating_review_shippers.rating)) AS average_rating'), DB::raw('COUNT(rating_review_shippers.id) AS total_rating' ))
    ->where('favorite_shippers.user_id' , Auth::id())
    ->groupBy('favorite_shippers.shipper_id')
    ->get();

    return view('front-user.favorites', compact('favProducts', 'favSellers', 'favShippers'));
  }

  public function orders($status = null)
  {  
    $user =  Auth::id();
    // $products = Product::leftjoin('product_categories', 'product_categories.id', '=', 'products.category_id')
    //             ->leftjoin('featured_products', 'featured_products.product_id', '=', 'products.id')
    //             ->leftjoin('rating_review_products', function($join)
    //              {
    //                $join->on('rating_review_products.product_id', '=', 'products.id');
    //                $join->where('rating_review_products.user_id', Auth::id());

    //              })
    //             ->select('products.*','rating_review_products.review','product_categories.name as category_name','featured_products.id as featured') 
                // ->get();

    $orders = Order::whereUserId(Auth::id())->orWhere(function ($q){
        $q->whereHas('products.product', function($q){
            $q->whereUserId(Auth::id())->orWhere('user_id', Auth::user()->parent_id)
            ->orWhereHas('user', function($q){
                $q->where('parent_id', Auth::id());
            });
        })->orWhereHas('products.auctionLot', function($q){
            $q->whereUserId(Auth::id())->orWhere('user_id', Auth::user()->parent_id)
            ->orWhereHas('user', function($q){
                $q->where('parent_id', Auth::id());
            });
        });
    })->orderBy('id','desc')->get();

    $pendingCount = 0;
    $dispatchedCount = 0;
    $onthewayCount = 0;
    $deliveredCount = 0;
    $cancelledCount = 0;
    foreach($orders as $order){
        foreach($order->products as $product)
        {
            if($product->status == 'pending')
            {
                $pendingCount += 1;
            }
            if($product->status == 'Dispatched')
            {
                $dispatchedCount += 1;
            }
            if($product->status == 'On the way')
            {
                $onthewayCount += 1;
            }
            if($product->status == 'Delivered')
            {
                $deliveredCount += 1;
            }
            if($product->status == 'Cancelled')
            {
                $cancelledCount += 1;
            }
        }
    }

    return view('front-user.orders', compact('orders', 'pendingCount', 'dispatchedCount', 
    'onthewayCount', 'deliveredCount', 'cancelledCount', 'status'));
  }

  public function changeOrderStatus(Request $request)
  {
        $order = OrderProduct::whereId($request->id)->first();

        if($order)
        {
            $order->status = $request->status;
            $order->save();

            $url = url('orders'.'/'. $order->status);
           
            if($order->status == 'cancelled')
            {
                $msg = 'Order Cancelled Successfully !';
            }else{
                $msg = 'Order Status Changed Successfully !';
            }

            $order->order->user->notify(new OrderStatusChangedNotification($order,$order->status));
            $name = $order->product ? $order->product->name : $order->auctionLot->lot_name;
            $subject = config('app.name')." - Your Order is ".$order->status ." for ".$name .' .';

            Mail::send('front-user.email.change-order-status-mail', ['order' => $order, 'status'=>$order->status], function($message) use ($order, $subject){
                $message->to($order->order->user->email);
                $message->subject($subject);
            });

            if($request->ajax())
            {
                return response([
                    'status' => true,
                    'msg' => 'Order cancelled successfully',
                    'url' => $url
                ]);
            }
            return redirect($url)->with('success', $msg);
            
        }else{
            if($request->ajax())
            {
                return response([
                    'status' => false,
                    'msg' => 'Something went wrong !',
                ]);
            }

            return redirect()->back()->with('error', 'Something went wrong!')->withInput();
        }
  }

    public function reviewSubmit(Request $request)
    {   
        $formData = request()->except(['_token', 'order_id']);  
        $formData['user_id'] = Auth::id();  

        $order = Order::whereId($request->order_id)->first();
        $orderProduct = OrderProduct::whereOrderId($order->id)->whereProductId($request->product_id)->first();
        $orderProduct->is_review = true;
        $orderProduct->save();

        $review = RatingReviewProduct::create($formData); 
        $order->is_review = true;
        $order->save();

        if ($review->save()) {
            $review->product->user->notify(new ProductReviewRatingNotification($review->product->user,$review));

            return redirect('/orders')->with('success', 'Rating Review for Product added successfully.');
        } else {
            return redirect('/orders')->with('error', 'Sorry there is an error while adding Rating Rreview . please try again.')->withInput();
        }   
    }

    public function sellerReviewSubmit(Request $request)
    {   
        $formData = request()->except(['_token', 'rfq_id']);  
        $formData['user_id'] = Auth::id();  

        $rfq = SellerRfqRespond::whereId($request->rfq_id)->first();
        $formData['seller_id'] = $rfq->seller_id;
        $review = RatingReviewSeller::create($formData); 
        $rfq->is_review = true;
        $rfq->save();

        if ($review->save()) {
            $review->seller->notify(new SellerReviewRatingNotification($review->seller,$review));

            return redirect('/RFQ-spot-submitted')->with('success', 'Rating Review for Product added successfully.');
        } else {
            return redirect('/RFQ-spot-submitted')->with('error', 'Sorry there is an error while adding Rating Rreview . please try again.')->withInput();
        }   
    }

    public function shipperReviewSubmit(Request $request)
    {   
        $formData = request()->except(['_token', 'rfq_id', 'response_id']);  
        $formData['user_id'] = Auth::id();  

        $rfq = null;
        if(isset($request->response_id))
        {
            $rfqResponse = ShipperRfqResponse::whereId($request->response_id)->first();
            $formData['shipper_id'] = $rfqResponse->user_id;
            $rfqResponse->is_review = true;
            $rfqResponse->save();

            $rfq = $rfqResponse->rfq;
        }else{
            $rfq = ShipperRfq::whereId($request->rfq_id)->first();
            $formData['shipper_id'] = $rfq->shipper_id;
            $rfq->is_review = true;
            $rfq->save();
        }
       
        $review = RatingReviewShipper::create($formData); 
       
        if ($review->save()) {
            $review->shipper->notify(new ShipperReviewRatingNotification($review->shipper,$review));

            if($rfq->order){
                return redirect('/shipping-spot-submitted'.'/'.$rfq->status)->with('success', 'Rating Review for shipper added successfully.');
            }elseif($rfq->rfq){
                return redirect('/shipping-spot-rfq-submitted'.'/'.$rfq->status)->with('success', 'Rating Review for shipper added successfully.');
            }elseif($rfq->auctionLot){
                return redirect('/shipping-spot-deal-submitted'.'/'.$rfq->status)->with('success', 'Rating Review for shipper added successfully.');
            }else{
                return redirect('/shipping-spot-rfq-submitted'.'/'.$rfq->status)->with('success', 'Rating Review for shipper added successfully.');
            }
        } else {
            return redirect('/shipping-spot-submitted'.'/'.$rfq->status)->with('error', 'Sorry there is an error while adding Rating Rreview . please try again.')->withInput();
        }   
    }


    public function importProductCsv(Request $request)
    { 
        if ($request->hasFile('product_csv')) {
            $allowedfileExtension = ['csv'];
            $file = $request->file('product_csv');

            $extension = $file->getClientOriginalExtension();

            if (! in_array($extension, $allowedfileExtension)) {

                return back()->with('error', 'Please select only csv file!')->withInput();
            }
        }
        $file = $request->file('product_csv');
 
        // File Details
        $filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $tempPath = $file->getRealPath();
        $fileSize = $file->getSize();
        $mimeType = $file->getMimeType();

        // Valid File Extensions
        $valid_extension = array("csv");

        // 2MB in Bytes
        $maxFileSize = 2097152;

        $filepath = null;
        // Check file extension
        if (in_array(strtolower($extension), $valid_extension)) {

            // Check file size
            if ($fileSize <= $maxFileSize) {

                // File upload location
                $location = 'uploads/uploaded_csv';


                $filepath = $file->move(base_path($location), $file->getClientOriginalName());

                // Reading file
                $file = fopen($filepath, "r");

                $importData_arr = array();
                $i = 0; 
 
                while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                    $num = count($filedata);

                    //dd($num);
                    // Skip first row (Remove below comment if you want to skip the first row)
                    if ($i <4) {
                        $i++;
                        continue;
                    }
                    for ($c = 0; $c < $num; $c++) {
                        $importData_arr[$i][] = $filedata[$c];
                        // break;                    
                    }
                    $i++;
                }
                fclose($file); 
                // dd($importData_arr);
                foreach ($importData_arr as $key => $row) { 
                    $price = str_replace(',', '', $row[4]);
                    $price = str_replace('$', '', $row[4]);
                    $name = $row[0];
                    $user_id = auth()->id(); 
                    $categories = explode(';', $row[1]);
                    $category_id = [];
                    foreach($categories as $category){
                        $productCat = ProductCategory::where('name',$category)->first();
                            if($productCat){
                                $category_id [] = $productCat->id;
                            }
                    }

                    // if($category_id == '')
                    // {
                    //     File::delete($filepath);

                    //     return redirect()->back()->with('error', 'Please add category for every product !');
                    // }

                    if(count($category_id) > 0){
                        $category_id = implode(',', $category_id);
                    }else{
                        $category_id = null;
                    }

                    $images =  $row[2] ;
                    $location = $row[3]; 
                    $price = $price;  
                    $stock = $row[5]; 
                    $low_stock = $row[6]; 
                    $buy_america_compliant = $row[7]; 
                    $product_type = $row[8]; 
                    $description = $row[9]; 
                    $specification = $row[10]; 
                    $product_weight = $row[11]; 
                    $product_length = $row[12]; 
                    $product_width = $row[13]; 
                    $product_height = $row[14]; 
                    $buying_format = $row[15]; 
                    $lead_time = $row[16]; 
                    $auction = $row[17]; 
                    $brand_name = $row[18];  
                    $state = $row[19]; 
                    $country = $row[20]; 
                    $freightClass = $row[21]; 
                    $nmfc = $row[22]; 

                    $nmfcCode = NmfcCode::whereNmfcCode($nmfc)->first();

                    if(! $nmfcCode)
                    {
                        $newNmfc = NmfcCode::create([
                            'nmfc_code' => $nmfc
                        ]);
                    }

                    if($user_id == '')
                    {
                        return redirect()->back()->with('error', 'Please add user id for every product !')->withInput();
                    }

                    if($name !== ''){

                        $insertData = array(
                            'name' => $name,
                            'user_id' => $user_id,
                            'category_id' => $category_id, 
                            'location' => str_replace(';', ',', $location),
                            'images' => str_replace(';', ',', $images),
                            'price' => $price, 
                            'stock' => $stock,
                            'low_stock' => $low_stock,
                            'buy_america_compliant' => $buy_america_compliant,
                            'product_type' => $product_type,
                            'description' => $description,
                            'specification' => $specification,
                            'product_weight' => $product_weight,
                            'product_length' => $product_length,
                            'product_width' => $product_width,
                            'product_height' => $product_height,
                            'buying_format' => $buying_format,
                            'lead_time' => $lead_time,
                            'auction' => $auction,
                            'brand_name' => $brand_name ,
                            'state' => $state ,
                            'country' => $country,
                            'freight_class' => $freightClass,
                            'nmfc_code' => $nmfc 
                        );

                        // dd($insertData);
                        Product::create($insertData);
                    } 
                }

            }
        }

        File::delete($filepath);
        // Excel::import(new SellerProductsImport(), $request->product_csv);
        return redirect('products-management')->with('success','Bulk Product  imported successfully');

    }

    public function dashboard()
    {
        $orders = Order::where('user_id', Auth::id())->orderBy('id','desc')->latest()->take(10)->get();
      
        return view('front-user.dashboard', compact('orders'));
    }

    public function saveRfqProducts(Request $request)
    {    
        $this->validate($request, [
            'due_by' => ['required', 'date'], 
        ], [
            "due_by.required" => "Please enter :attribute", 
            "due_by.date" => "Please enter valid date", 
        ]);
// dd($request->all());
try { 
           
        return  DB::transaction(function () use($request) {
            $formData = request()->except(['_token','images','new_nmfc_code','user_id','category_id','name','description', 'product_weight','product_length','product_width','product_height','price','quantity' ,'unit','hazmat','oversize','load_type' ,'rfq','another-product']);

            $formData['user_id'] = Auth::id(); 

            if($request->rfq_no == null)
            {
                $no = str_replace( array( '_', '.','-' ), ' ',Auth::user()->email);
                $no = substr($no, 0, 6);
                $formData['rfq_no'] = $no.(string) mt_rand(111111, 999999);
            }
            
            if(isset($request->buy_america_compliant)){
                $request->buy_america_compliant = 'yes';
            }else{
                $request->buy_america_compliant = 'no';
            }
        
            // $uploadedMedias=''; 
            // if($request->hasfile('images')){
            //     foreach($request->file('images') as $file){

            //         $allowedfileExtension = ['jpeg', 'jpg', 'png', 'svg', 'JPG', 'PNG', 'JPEG', 'SVG']; 
            //         $extension = $file->getClientOriginalExtension(); 
            //         if (in_array($extension, $allowedfileExtension)) { 
            //             $name = "prod".str_random(5).time().'.'.$file->extension();
            //             $file->move(public_path().'/storage/app/product-images/', $name);
            //             $uploadedMedias .= "product-images/".$name.",";
            //         }
            //     }
            // }
            // $formData['images'] = substr_replace($uploadedMedias,'',-1); 
            $rfqImages = [];
            $Product = Rfq::create($formData); 
            $total = 0;
            if ($Product->save()) { 
                $i = 0; 
                foreach($request->name as $name){  

                    $productCheck = Product::where('id',$request->name[$i])->first(); 
                    $uploadedMedias=''; 
                    
                    // if(isset($request->file('images')[$i])){
                    //     foreach($request->file('images')[$i] as $file){
                    //         if(is_file($file)){
                
                    //             $allowedfileExtension = ['jpeg', 'jpg', 'png', 'svg', 'JPG', 'PNG', 'JPEG', 'SVG']; 
                    //             $extension = $file->getClientOriginalExtension(); 
                    //             if (in_array($extension, $allowedfileExtension)) { 
                    //                 $name = "prod".str_random(5).time().'.'.$file->extension();
                    //                 $file->move(public_path().'/storage/app/product-images/', $name);
                    //                 $uploadedMedias .= "product-images/".$name.",";
                    //                 // $rfqImages [] = "product-images/".$name;
                    //             }
                    //         }
                    //     }
                    // }
                    $rfqImages = [];
                    // $productImages = substr_replace($uploadedMedias,'',-1); 
                    if(isset($request->images[$i])){
                        $productImages = implode(',', $request->images[$i]);
                    }else{
                        $productImages = null;
                    }

                    if(isset($request->specification[$i])){
                        $productSpecs = implode(',', $request->specification[$i]);
                    }else{
                        $productSpecs = null;
                    }

                    if(isset($request->category_id[$i])){
                        $category_id = implode(',', $request->category_id[$i]);
                    }

                    $nmfc_code = null;
                    if( isset($request->nmfc_code[$i]) && $request->nmfc_code[$i] == 'other' && isset($request->new_nmfc_code[$i]) && $request->new_nmfc_code[$i] != null)
                    {
                        $nmfcExist = NmfcCode::whereNmfcCode($request->new_nmfc_code[$i])->first();
                        if(! $nmfcExist){
                            $nmfc = NmfcCode::create([
                                'nmfc_code' => $request->new_nmfc_code[$i]
                            ]);
                
                            $nmfc_code  = $nmfc->nmfc_code;
                        }else{
                            $nmfc_code  = $nmfcExist->nmfc_code;
                        }
                        
                    }elseif(isset($request->nmfc_code[$i])){
                        $nmfc_code = $request->nmfc_code[$i];
                    }

                    if($productCheck){     

                        if($productCheck->images != null)
                        {
                            $images = explode(',', $productCheck->images);
                            if($productImages != ''){
                                $newImages = explode(',', $productImages );
                        
                                $mergeImage =  array_merge($images, $newImages);

                                $productImages = implode(',', array_filter($mergeImage));
                                $rfqImages[]=  $productImages;
                            }else{
                                $productImages = $productCheck->images;
                                $rfqImages[] =  $productImages ;
                            }
                        }


                        $productData = array(
                            'user_id' => Auth::user()->id,
                            'category_id' => $category_id,
                            'name' => $productCheck->name, 
                            'description' => isset($request->description[$i]) ? $request->description[$i] : '', 
                            'buy_america_compliant' => $request->buy_america_compliant, 
                            'product_weight' => $request->product_weight[$i],
                            'product_length' => $request->product_length[$i],
                            'product_width' => $request->product_width[$i],
                            'product_height' => $request->product_height[$i],
                            'price' => isset($request->price[$i]) ? $request->price[$i] : 0, 
                            'quantity' => $request->quantity[$i], 
                            // 'unit' => $request->unit[$i], 
                            'lead_time' => isset($request->lead_time[$i])?$request->lead_time[$i]:$productCheck->lead_time, 
                            'hazmat' => isset($request->hazmat[$i])?$request->hazmat[$i]:'no',
                            'oversize' => isset($request->oversize[$i])?$request->oversize[$i]:'no',
                            'product_type' => isset($request->product_type[$i])?$request->product_type[$i]:'used',
                            'load_type' => isset($request->load_type[$i])?$request->load_type[$i]:null,
                            'rfq' => $Product->id,
                            'parent_id' => $productCheck->id,
                            'freight_class' => isset($request->freight_class[$i]) ? $request->freight_class[$i] : $productCheck->freight_class , 
                            'nmfc_code' => $nmfc_code,
                            'images' => $productImages,
                            // 'mileage' => $request->mileage[$i],
                            // 'hours' => $request->hours[$i],
                            'packaging' =>isset($request->packaging[$i]) ? $request->packaging[$i] : $productCheck->packaging ,
                            'specification' => $productSpecs != null ? $productSpecs :$productCheck->specification,
                        ) ;    
                        Product::create($productData);

                        if(isset($request->price[$i]) && $request->price[$i] != "" && $request->price[$i] > 0)
                        {
                            $total += $request->price[$i] * $request->quantity[$i];
                        }
                    }else{
                
                        $productData = array(
                            'user_id' => Auth::user()->id,
                            'category_id' => $category_id,
                            'name' => $request->name[$i], 
                            'description' => $request->description[$i], 
                            'buy_america_compliant' => $request->buy_america_compliant, 
                            'product_weight' => $request->product_weight[$i],
                            'product_length' => $request->product_length[$i],
                            'product_width' => $request->product_width[$i],
                            'product_height' => $request->product_height[$i],
                            'price' => isset($request->price[$i]) ? $request->price[$i] : 0, 
                            'quantity' => $request->quantity[$i], 
                            // 'unit' => $request->unit[$i], 
                            'lead_time' => isset($request->lead_time[$i])?$request->lead_time[$i]:null, 
                            'hazmat' => isset($request->hazmat[$i])?$request->hazmat[$i]:'no',
                            'oversize' => isset($request->oversize[$i])?$request->oversize[$i]:'no',
                            'product_type' => isset($request->product_type[$i])?$request->product_type[$i]:'used',
                            'load_type' => isset($request->load_type[$i])?$request->load_type[$i]:null,
                            'rfq' => $Product->id,
                            'freight_class' => isset($request->freight_class[$i]) ? $request->freight_class[$i] : ' ' , 
                            'nmfc_code' => $nmfc_code,
                            'specification' => $productSpecs,
                            'images' => $productImages,
                            // 'mileage' => $request->mileage[$i],
                            // 'hours' => $request->hours[$i],
                            'packaging' => isset($request->packaging[$i]) ? $request->packaging[$i] : null,
                        ) ;    
                        Product::create($productData);

                        if(isset($request->price[$i]) && $request->price[$i] != "" && $request->price[$i] > 0)
                        {
                            $total += $request->price[$i] * $request->quantity[$i];
                        }
                    }

                    
                    $rfqData = Rfq::find($Product->id);

                    if(isset($request->category_id[$i])){
                        foreach( $request->category_id[$i] as $cat){
                            $users = User::where('category_id',$cat)->where('user_type','seller')->where('id','!=', Auth::id())->get();
        
                            if(count($users) > 0){
                                
                                foreach($users as $user){ 
                                    $user->notify(new RfqToSellers($user,$rfqData,$productData));
                                }
                            }else{
                                $users = User::where('user_type','seller')->where('id','!=', Auth::id())->get();

                                foreach($users as $user){ 
                                    $user->notify(new RfqToSellers($user,$rfqData,$productData));
                                }
                            }

                        }
                    }
                    $i++;

                }

                $Product->images = implode(',', $rfqImages);
                $Product->total = $total;
                $Product->save();

                return redirect('/product-spot/rfq_spot')->with('success', 'RFQ Products added successfully.');
            } else {
                return redirect('/product-spot/rfq_spot')->with('error', 'Sorry there is an error while adding Product. please try again.')->withInput();
            }  
            });
        } catch (Exception $e) {
            return back()->with('error',$e->getMessage())->withInput();
        }
    }


    public function rfqShippingSpot()
    {
        return view('front-user.pages.rfq-order-placed');
    }


    public function manageRfqProducts($status = null)
    { 
        $proposals = Rfq::leftjoin('seller_rfq_responds', function($join)
                 {
                   $join->on('seller_rfq_responds.rfq_id', '=', 'rfqs.id'); 

                 })
                 ->select('rfqs.*','seller_rfq_responds.id as respond',  'seller_rfq_responds.status as respondStatus',
                 'seller_rfq_responds.payment_status as respondPaymentStatus')
                 ->where('rfqs.user_id', Auth::id())
                 ->where('rfqs.seller_id', null)
                 ->where('rfqs.rfq_status', '!=', 'closed')
                 ->orderBy('rfqs.id', 'desc')->groupBy('rfqs.id')->get(); 


        $completed = Rfq::leftjoin('seller_rfq_responds', function($join)
                 {
                   $join->on('seller_rfq_responds.rfq_id', '=', 'rfqs.id'); 
                    $join->whereIn('seller_rfq_responds.payment_status', ['success', 'hold', 'pending']);
                 })
                 ->select('rfqs.*','seller_rfq_responds.id as respond' ,'seller_rfq_responds.product_id as productId', 'seller_rfq_responds.id as respond', 'seller_rfq_responds.status as respondStatus',
                 'seller_rfq_responds.payment_status as respondPaymentStatus', 'seller_rfq_responds.is_review as isReview')
                 ->where('rfqs.user_id', Auth::id())
                //  ->where('rfqs.seller_id','!=', null)
                 ->where('rfqs.rfq_status', '!=', 'closed')
                 ->orderBy('rfqs.id', 'desc')->groupBy('seller_rfq_responds.id')->get(); 

        return view('front-user.RFQ-spot-submitted', compact('proposals','completed', 'status')); 
    }

    public function saveSellerRfqRespond(Request $request)
    {     
        // dd($request->all());
        $this->validate($request, [
            'shipment_date' => ['required', 'date'], 
            'documents.*' => ['max:2560', 'mimes:jpeg,bmp,png,doc,docx,jpg,pdf,png,pptx,rtf,txt,xlsx,csv']
        ], [
            "shipment_date.required" => "Please enter :attribute", 
            'documents.*.max' => 'Please upload document size less than 10 MB',
            'documents.*.mimes' => 'Please upload valid document type'
        ]);

        $groupUserRespond = null;
        if(Auth::user()->parent_id != null)
        {
            $groupUserRespond = SellerRfqRespond::whereRfqId($request->rfq_id)->whereSellerId(Auth::user()->parent_id)->first();
        }else{
            foreach(Auth::user()->children as $child){
                if(SellerRfqRespond::whereRfqId($request->rfq_id)->whereSellerId($child->id)->first()){
                    $groupUserRespond = SellerRfqRespond::whereRfqId($request->rfq_id)->whereSellerId($child->id)->first();
                }
            }
        }

        if(! isset($request->product_ids))
        {
            return redirect()->back()->with('error', 'No products in RFQ !')->withInput();
        }

        if($groupUserRespond)
        {
            return redirect()->back()->with('error', 'Your group member already applied to this RFQ')->withInput();
        }
        
        $Product = sellerRfqRespond::whereSellerId(Auth::id())->whereRfqId($request->rfq_id)->first();

        $finalPrice = 0;
      
            // $product = RfqProducts::find($id);

        $membership = UserMembershipPlan::whereUserId(Auth::id())->whereStatus('Active')->latest()->first();

        $uploadedMedias=''; 
        if($request->hasfile('documents')){
            foreach($request->file('documents') as $file){
                $extension = $file->getClientOriginalExtension();  
                $name = "prod".str_random(5).time().'.'.$file->extension();
                $file->move(public_path().'/storage/app/rfq-documents/', $name);
                $uploadedMedias .= "rfq-documents/".$name.","; 
            }
        }
        $documents = substr_replace($uploadedMedias,'',-1); 

        if($Product)
        {
            if($Product->documents != null)
            {
                $images = explode(',', $Product->documents);
                if($documents != ''){
                    $newImages = explode(',', $documents );
               
                    $mergeImage =  array_merge($images, $newImages);

                    $documents = implode(',', $mergeImage);
                }else{
                    $documents = $Product->documents;
                }
            }
        }

        $productData = array(
                    'seller_id' => Auth::user()->id,
                    'documents' => $documents,
                    'rfq_id' => $request->rfq_id ,
                    'comments' => $request->comments ,
                    'total' => $request->total,
                    'shipment_date' => date("Y-m-d", strtotime($request->shipment_date)) , 
                    'final_price' => $finalPrice,
                    'commission' => 0
                ) ;   

                $response = SellerRfqRespond::whereRfqId($request->rfq_id)->whereSellerId(Auth::id())->first();

                if ($request->buy_america_compliant != 'yes') {
                    $request->buy_america_compliant = '';
                }

                if($response){
                    $response->buy_america_compliant = $request->buy_america_compliant;
                    $response->save();
                }
              
                $rfq = Rfq::find($request->rfq_id);
                $user = User::find($rfq->user_id);
                $seller = User::find(Auth::user()->id);

                if($Product){
                    foreach($request->product_ids as $key => $id)
                    {
                        $nmfc_code = null;
                        if( isset($request->nmfc_code[$key]) && $request->nmfc_code[$key] == 'other' && isset($request->new_nmfc_code[$key]) && $request->new_nmfc_code[$key] != null)
                        {
                            $nmfcExist = NmfcCode::whereNmfcCode($request->new_nmfc_code[$key])->first();
                        if(! $nmfcExist){
                            $nmfc = NmfcCode::create([
                                'nmfc_code' => $request->new_nmfc_code[$key]
                            ]);
                
                            $nmfc_code  = $nmfc->nmfc_code;
                        }else{
                            $nmfc_code  = $nmfcExist->nmfc_code;
                        }
                        }elseif(isset($request->nmfc_code[$key])){
                            $nmfc_code = $request->nmfc_code[$key];
                        }

                        $rfqProduct = RfqProducts::whereSellerRfqRespondId($Product->id)->whereProductId($id)->first();
                        if($rfqProduct){
                            $rfqProduct->update([
                                'seller_rfq_respond_id' => $Product->id,
                                'product_id' => $id,
                                'description' => $request->description[$key],
                                'product_weight' => $request->product_weight[$key],
                                'product_length' => $request->product_length[$key],
                                'product_height' => $request->product_height[$key],
                                'product_width' => $request->product_width[$key],
                                'price' => $request->price[$key],
                                'unit_price' => $request->unit_price[$key],
                                'lead_time' => $request->lead_time[$key],
                                'packaging' => $request->packaging[$key],
                                'load_type' => isset($request->load_type[$key]) ? $request->load_type[$key] : '',
                                'freight_class' => isset($request->freight_class[$key]) ? $request->freight_class[$key] : '',
                                'nmfc_code' => $nmfc_code ,
                                ]);
                        }else{
                            RfqProducts::create([
                                'seller_rfq_respond_id' => $Product->id,
                                'product_id' => $id,
                                'description' => $request->description[$key],
                                'product_weight' => $request->product_weight[$key],
                                'product_length' => $request->product_length[$key],
                                'product_height' => $request->product_height[$key],
                                'product_width' => $request->product_width[$key],
                                'price' => $request->price[$key],
                                'unit_price' => $request->unit_price[$key],
                                'lead_time' => $request->lead_time[$key],
                                'packaging' => $request->packaging[$key],
                                'load_type' => isset($request->load_type[$key]) ? $request->load_type[$key] : '',
                                'freight_class' => isset($request->freight_class[$key]) ? $request->freight_class[$key] : '',
                                'nmfc_code' => $nmfc_code ,
                            ]);
                        }

                        $finalPrice += $request->price[$key];
                    }
                    $productData['final_price'] = $finalPrice;
                    $Product->update($productData);
                    // $user->notify(new RfqRespondNotification($rfq,$Product,$seller));
                }else{
                    $Product = SellerRfqRespond::create($productData); 
                    foreach($request->product_ids as $key => $id)
                    {
                        $nmfc_code = null;
                        if( isset($request->nmfc_code[$key]) && $request->nmfc_code[$key] == 'other' && isset($request->new_nmfc_code[$key]) && $request->new_nmfc_code[$key] != null)
                        {
                            $nmfcExist = NmfcCode::whereNmfcCode($request->new_nmfc_code[$key])->first();
                            if(! $nmfcExist){
                                $nmfc = NmfcCode::create([
                                    'nmfc_code' => $request->new_nmfc_code[$key]
                                ]);
                    
                                $nmfc_code  = $nmfc->nmfc_code;
                            }else{
                                $nmfc_code  = $nmfcExist->nmfc_code;
                            }
                        }elseif(isset($request->nmfc_code[$key])){
                            $nmfc_code = $request->nmfc_code[$key];
                        }
                        RfqProducts::create([
                            'seller_rfq_respond_id' => $Product->id,
                            'product_id' => $id,
                            'description' => $request->description[$key],
                            'product_weight' => $request->product_weight[$key],
                            'product_length' => $request->product_length[$key],
                            'product_height' => $request->product_height[$key],
                            'product_width' => $request->product_width[$key],
                            'price' => $request->price[$key],
                            'unit_price' => $request->unit_price[$key],
                            'lead_time' => $request->lead_time[$key],
                            'packaging' => $request->packaging[$key],
                            'load_type' => isset($request->load_type[$key]) ? $request->load_type[$key] : '',
                            'freight_class' => isset($request->freight_class[$key]) ? $request->freight_class[$key] : '',
                            'nmfc_code' => $nmfc_code ,
                        ]);

                        $finalPrice += $request->price[$key];
                    }
                    $productData['final_price'] =$finalPrice > 0 ? $finalPrice : $rfq->total;
                    $Product->final_price = $finalPrice > 0 ? $finalPrice : $rfq->total;
                    $Product->save();
                }

                $adminCommision = AdminCommission::first();
              
                if(Auth::user()->commission > 0)
                {
                    $commission = ($finalPrice * Auth::user()->commission) / 100;

                }elseif(Auth::user()->company && Auth::user()->company->commission > 0)
                {
                    $commission = $finalPrice * Auth::user()->company->commission / 100;
                }elseif($membership)
                {
                    $plan = SubscriptionPlan::whereName($membership->membership_plan)->first();
                    if($plan){
                        $commission = $finalPrice * $plan->commission / 100;
                    }else{
                        $commission = $finalPrice * $adminCommision->seller_commission / 100;
                    }
                }else{

                    $commission = $finalPrice * $adminCommision->seller_commission / 100;
                }
                
                $Product->commission = ceil($commission);
                $Product->save();

                $user->notify(new RfqRespondNotification($rfq,$Product,$seller, $Product));
               
        if ($Product->save()) { 

            return redirect('/RFQ-spot-requested')->with('success', 'RFQ respond sent successfully.'); 
        } else {
            return redirect('/RFQ-spot-requested')->with('error', 'Sorry there is an error while sending response. please try again.')->withInput();
        }   
    }

    public function saveSellerRfqRespondProduct(Request $request)
    {     
        // dd($request->all());
        $this->validate($request, [
            'shipment_date' => ['required', 'date'], 
            'documents.*' => ['max:2560', 'mimes:jpeg,bmp,png,doc,docx,jpg,pdf,png,pptx,rtf,txt,xlsx,csv']
        ], [
            "shipment_date.required" => "Please enter :attribute", 
            'documents.*.max' => 'Please upload document size less than 10 MB',
            'documents.*.mimes' => 'Please upload valid document type'
        ]);

        if(! isset($request->product_id))
        {
            return redirect()->back()->with('error', 'No products in RFQ !')->withInput();
        }

        $groupUserRespond = null;
        if(Auth::user()->parent_id != null)
        {
            $groupUserRespond = SellerRfqRespond::whereRfqId($request->rfq_id)->whereSellerId(Auth::user()->parent_id)->first();
        }else{
            foreach(Auth::user()->children as $child){
                if(SellerRfqRespond::whereRfqId($request->rfq_id)->whereSellerId($child->id)->first()){
                    $groupUserRespond = SellerRfqRespond::whereRfqId($request->rfq_id)->whereSellerId($child->id)->first();
                }
            }
        }
        
        $Product = sellerRfqRespond::whereSellerId(Auth::id())->whereRfqId($request->rfq_id)
        ->whereProductId($request->product_id)->first();

        $finalPrice = 0;
      
            // $product = RfqProducts::find($id);

        $membership = UserMembershipPlan::whereUserId(Auth::id())->whereStatus('Active')->latest()->first();

        $uploadedMedias=''; 
        if($request->hasfile('documents')){
            foreach($request->file('documents') as $file){
                $extension = $file->getClientOriginalExtension();  
                $name = "prod".str_random(5).time().'.'.$file->extension();
                $file->move(public_path().'/storage/app/rfq-documents/', $name);
                $uploadedMedias .= "rfq-documents/".$name.","; 
            }
        }
        $documents = substr_replace($uploadedMedias,'',-1); 

        if($Product)
        {
            if($Product->documents != null)
            {
                $images = explode(',', $Product->documents);
                if($documents != ''){
                    $newImages = explode(',', $documents );
               
                    $mergeImage =  array_merge($images, $newImages);

                    $documents = implode(',', $mergeImage);
                }else{
                    $documents = $Product->documents;
                }
            }
        }
        $productData = array(
                    'seller_id' => Auth::user()->id,
                    'product_id' => $request->product_id,
                    'documents' => $documents,
                    'rfq_id' => $request->rfq_id ,
                    'comments' => $request->comments ,
                    'total' => $request->total,
                    'shipment_date' => date("Y-m-d", strtotime($request->shipment_date)) , 
                    'final_price' => $finalPrice,
                    'commission' => 0
                ) ;   

                $response = SellerRfqRespond::whereRfqId($request->rfq_id)->whereSellerId(Auth::id())
                ->whereProductId($request->product_id)->first();

                if ($request->buy_america_compliant != 'yes') {
                    $request->buy_america_compliant = '';
                }

                if($response){
                    $response->buy_america_compliant = $request->buy_america_compliant;
                    $response->save();
                }
              
                $rfq = Rfq::find($request->rfq_id);
                $user = User::find($rfq->user_id);
                $seller = User::find(Auth::user()->id);

                if($Product){
                    if($request->product_id)
                    {
                        $id = $request->product_id;

                        $nmfc_code = null;
                        if( isset($request->nmfc_code) && $request->nmfc_code == 'other' && isset($request->new_nmfc_code) && $request->new_nmfc_code != null)
                        {
                            $nmfcExist = NmfcCode::whereNmfcCode($request->new_nmfc_code)->first();
                            if(! $nmfcExist){
                                $nmfc = NmfcCode::create([
                                    'nmfc_code' => $request->new_nmfc_code
                                ]);
                    
                                $nmfc_code  = $nmfc->nmfc_code;
                            }else{
                                $nmfc_code  = $nmfcExist->nmfc_code;
                            }
                        }elseif(isset($request->nmfc_code)){
                            $nmfc_code = $request->nmfc_code;
                        }

                        $rfqProduct = RfqProducts::whereSellerRfqRespondId($Product->id)->whereProductId($id)->first();
                        if($rfqProduct){
                            $rfqProduct->update([
                                'seller_rfq_respond_id' => $Product->id,
                                'product_id' => $id,
                                'description' => $request->description,
                                'product_weight' => $request->product_weight,
                                'product_length' => $request->product_length,
                                'product_height' => $request->product_height,
                                'product_width' => $request->product_width,
                                'price' => $request->price,
                                'unit_price' => $request->unit_price,
                                'lead_time' => $request->lead_time,
                                'packaging' => $request->packaging[$key],
                                'load_type' => isset($request->load_type) ? $request->load_type : '',
                                'freight_class' => isset($request->freight_class) ? $request->freight_class : '',
                                'nmfc_code' => $nmfc_code ,
                                ]);
                        }else{
                            RfqProducts::create([
                                'seller_rfq_respond_id' => $Product->id,
                                'product_id' => $id,
                                'description' => $request->description,
                                'product_weight' => $request->product_weight,
                                'product_length' => $request->product_length,
                                'product_height' => $request->product_height,
                                'product_width' => $request->product_width,
                                'price' => $request->price,
                                'unit_price' => $request->unit_price,
                                'lead_time' => $request->lead_time,
                                'packaging' => $request->packaging,
                                'load_type' => isset($request->load_type) ? $request->load_type : '',
                                'freight_class' => isset($request->freight_class) ? $request->freight_class : '',
                                'nmfc_code' => $nmfc_code ,
                            ]);
                        }

                        $finalPrice += $request->price;
                    }
                    $productData['final_price'] = $finalPrice;
                    $Product->update($productData);
                    // $user->notify(new RfqRespondNotification($rfq,$Product,$seller));
                }else{
                    $Product = SellerRfqRespond::create($productData); 
                    if($request->product_id)
                    {
                        $id = $request->product_id;
                        $nmfc_code = null;
                        if( isset($request->nmfc_code) && $request->nmfc_code == 'other' && isset($request->new_nmfc_code) && $request->new_nmfc_code != null)
                        {
                            $nmfcExist = NmfcCode::whereNmfcCode($request->new_nmfc_code)->first();
                            if(! $nmfcExist){
                                $nmfc = NmfcCode::create([
                                    'nmfc_code' => $request->new_nmfc_code
                                ]);
                    
                                $nmfc_code  = $nmfc->nmfc_code;
                            }else{
                                $nmfc_code  = $nmfcExist->nmfc_code;
                            }
                        }elseif(isset($request->nmfc_code)){
                            $nmfc_code = $request->nmfc_code;
                        }
                        RfqProducts::create([
                            'seller_rfq_respond_id' => $Product->id,
                            'product_id' => $id,
                            'description' => $request->description,
                            'product_weight' => $request->product_weight,
                            'product_length' => $request->product_length,
                            'product_height' => $request->product_height,
                            'product_width' => $request->product_width,
                            'price' => $request->price,
                            'unit_price' => $request->unit_price,
                            'lead_time' => $request->lead_time,
                            'packaging' => $request->packaging,
                            'load_type' => isset($request->load_type) ? $request->load_type : '',
                            'freight_class' => isset($request->freight_class) ? $request->freight_class : '',
                            'nmfc_code' => $nmfc_code ,
                        ]);

                        $finalPrice += $request->price;
                    }
                    $productData['final_price'] =$finalPrice > 0 ? $finalPrice : $rfq->total;
                    $Product->final_price = $finalPrice > 0 ? $finalPrice : $rfq->total;
                    $Product->save();
                }
             
                $adminCommision = AdminCommission::first();

                if(Auth::user()->commission > 0)
                {
                    $commission = ($finalPrice * Auth::user()->commission) / 100;

                }elseif(Auth::user()->company && Auth::user()->company->commission > 0)
                {
                    $commission = $finalPrice * Auth::user()->company->commission / 100;
                }elseif($membership)
                {
                    $plan = SubscriptionPlan::whereName($membership->membership_plan)->first();
                    if($plan){
                        $commission = $finalPrice * $plan->commission / 100;
                    }else{
                    $commission = $finalPrice * $adminCommision->seller_commission / 100;
                    }
                }else{

                    $commission = $finalPrice * $adminCommision->seller_commission / 100;
                }
                
                $Product->commission = ceil($commission);
                $Product->save();

                $user->notify(new RfqRespondNotification($rfq,$Product,$seller, $Product));
               
        if ($Product->save()) { 

            return redirect('/RFQ-spot-requested')->with('success', 'RFQ respond sent successfully.'); 
        } else {
            return redirect('/RFQ-spot-requested')->with('error', 'Sorry there is an error while sending response. please try again.')->withInput();
        }   
    }

    public function deleteSellerRfqDocument(Request $request)
    {
        $rfq = SellerRfqRespond::find($request->id);

        if($rfq)
        {
            $images = explode(',', $rfq->documents);

           foreach($images as $key => $image)
           {
            if($image == $request->image){
                File::delete($images[$key]);

                unset($images[$key]);

                $rfq->documents = implode(',', $images);
                $rfq->save();
            }
           }

           return response([
            'status' => true,
            'msg' => 'Document deleted successfully.'
           ]);
        }else{
            return response([
                'status' => false,
                'msg' => 'Something went wrong'
               ]);
        }
      

    }

    public function changeStatusRfq(Request $request)
    {
        // dd($request->all());
        if($request->response_id){
            SellerRfqRespond::find($request->response_id)->update([
                'status' => $request->status
            ]);
        }else{
            Rfq::find($request->id)->update(['rfq_status' => $request->status ]);
        }
        $response = SellerRfqRespond::find($request->response_id);
        $rfq = Rfq::find($request->id);
        $user = User::find($rfq->user_id);
        $user->notify(new RfqStatusChangedNotification($rfq,$request->status, $response));
 
        return redirect('/RFQ-spot-requested')->with('success', 'You have successfully updated RFQ');
        
    }

    public function rfqExist(Request $request)
    {
        $rfq = Rfq::whereRfqNo($request->rfq_no)->first();

        if($rfq)
        {
            return response()->json([
                'status' => true
            ]);
        }else{
            return response()->json([
                'status' => false
            ]);
        }
    }

    public function createAuctionLot()
    {
        $products = Product::whereUserId(Auth::id())->whereNull('rfq')->get();

        return view('front-user.create-auction-lot', compact('products')); 
    }
     
    public function saveAuctionLot(Request $request)
    {
        $formData = request()->except(['_token', 'images', 'auction_image', 'product_id']);
        $formData['bid_date'] = carbon::now()->addDays($formData['bid_days'] + 1);
        $formData['product_ids'] = implode(',', $request->product_id);
        $formData['user_id'] = Auth::id();

        if ($request->hasFile('specification')) {
            $allowedfileExtension = ['jpeg', 'jpg', 'png', 'svg'];
            $file = $request->file('specification');

            $extension = $file->getClientOriginalExtension();

            if (in_array($extension, $allowedfileExtension)) {

                $formData['specification'] = $file->store('specifications');
            }else{
                return back()->with('error', 'Please select only image for specification !')->withInput();
            }
        }

        // if ($request->hasFile('auction_image')) {
        //     $allowedfileExtension = ['jpeg', 'jpg', 'png', 'svg'];
        //     $file = $request->file('auction_image');

        //     $extension = $file->getClientOriginalExtension();

        //     if (in_array($extension, $allowedfileExtension)) {

        //         $formData['auction_image'] = $file->store('auction_images');
        //     }else{
        //         return back()->with('error', 'Please select only image for auction_image !')->withInput();
        //     }
        // }

        $auctionLot = AuctionLot::create($formData);

        if($request->hasFile('auction_image')){
            foreach($request->file('auction_image') as $auctionImg){
                $allowedfileExtension = ['jpeg', 'jpg', 'png', 'svg'];
                $file = $auctionImg;

                $extension = $file->getClientOriginalExtension();

                if (in_array($extension, $allowedfileExtension)) {

                    $auctionImage = $file->store('auction_image');
                }else{
                    return back()->with('error', 'Please select only image for auction_image !')->withInput();
                }

                AuctionImage::create([
                    'auction_lot_id' => $auctionLot->id,
                    'image' => $auctionImage
                ]);
            }
        }
        // if($request->hasfile('images')){
        //     foreach($request->file('images') as $file){

        //         if($file != ''){
        //             $allowedfileExtension = ['jpeg', 'jpg', 'png', 'svg', 'JPG', 'PNG', 'JPEG', 'SVG', 'mov', 'mp4', 'webm', 'mkv', 'MP4']; 
        //             $extension = $file->getClientOriginalExtension(); 
        //             if (in_array($extension, $allowedfileExtension)) { 
        //                 $name = "prod".str_random(5).time().'.'.$file->extension();
        //                 $file->move(public_path().'/storage/app/auction-images/', $name);
        //                 $image = "auction-images/".$name;

        //                 AuctionImage::create([
        //                     'product_id' => $id,
        //                     'auction_lot_id' => $auctionLot->id,
        //                     'image' => $image
        //                 ]);
        //             }
        //         }
        //     }
        // }

        
        foreach($request->product_id as $key => $id)
        {
            $product = Product::whereId($id)->first();

            if(isset($request->file('images')[$key])){
                foreach($request->file('images')[$key] as $img){

                    $allowedfileExtension = ['jpeg', 'jpg', 'png', 'svg', 'JPG', 'PNG', 'JPEG', 'SVG', 'mov', 'mp4', 'webm', 'mkv', 'MP4']; 
                    $extension = $img->getClientOriginalExtension(); 
                    if (in_array($extension, $allowedfileExtension)) { 
                        $name = "prod".str_random(5).time().'.'.$img->extension();
                        $img->move(public_path().'/storage/app/auction-images/', $name);
                        $images = "auction-images/".$name;

                        AuctionImage::create([
                            'product_id' => $id,
                            'auction_lot_id' => $auctionLot->id,
                            'image' => $images
                        ]);
                    }
                }
            }

            if($product && $product->images){
                $images = explode(',',$product->images);
                foreach($images as $img){
                    if($img != ''){
                    
                        AuctionImage::create([
                            'product_id' => $id,
                            'auction_lot_id' => $auctionLot->id,
                            'image' => $img
                        ]);
                    }
                }
            }
        }

        return redirect('/deal-spot-posted/deal-products')->with('success', 'Auction Lot saved successfully.');
    }

    public function editAuctionLot($id)
    {
        $products = Product::whereUserId(Auth::id())->whereNull('rfq')->get();
        $auctionLot = AuctionLot::whereId($id)->first();

        return view('front-user.edit-auction-lot', compact('products', 'auctionLot')); 
    }
     
    public function updateAuctionLot(Request $request, $id)
    {
        $formData = request()->except(['_token', 'images', 'auction_image', 'product_id', 'product_ids']);
        $formData['product_ids'] = implode(',', $request->product_id);
    //    dd($formData);
        $auctionLot = AuctionLot::whereId($id)->first();
        if($auctionLot->bid_days != $formData['bid_days']){
            $days = $formData['bid_days'] - $auctionLot->bid_days ;

            $formData['bid_date'] = carbon::parse($auctionLot->bid_date)->addDays($days);
        }

        if(isset($request->is_freight_included) == false){
            $formData['is_freight_included'] = 0;
        }

        if ($request->hasFile('specification')) {
            $allowedfileExtension = ['jpeg', 'jpg', 'png', 'svg'];
            
            $file = $request->file('specification');
            File::delete($auctionLot->specification);

            $extension = $file->getClientOriginalExtension();

            if (in_array($extension, $allowedfileExtension)) {

                $formData['specification'] = $file->store('specifications');
            }else{
                return back()->with('error', 'Please select only image for specification !')->withInput();
            }
        }else{
            $formData['specification'] = $auctionLot->specification;
        }

        
        // if ($request->hasFile('auction_image')) {
        //     $allowedfileExtension = ['jpeg', 'jpg', 'png', 'svg'];
        //     $file = $request->file('auction_image');

        //     $extension = $file->getClientOriginalExtension();

        //     if (in_array($extension, $allowedfileExtension)) {

        //         $formData['auction_image'] = $file->store('auction_images');
        //     }else{
        //         return back()->with('error', 'Please select only image for auction_image !')->withInput();
        //     }
        // }else{
        //     $formData['auction_image'] = $auctionLot->auction_image;
        // }

        $auctionLot->update($formData);

        if($request->hasFile('auction_image')){
            foreach($request->file('auction_image') as $auctionImg){
                $allowedfileExtension = ['jpeg', 'jpg', 'png', 'svg'];
                $file = $auctionImg;
    
                $extension = $file->getClientOriginalExtension();
    
                if (in_array($extension, $allowedfileExtension)) {
    
                    $auctionImage = $file->store('auction_image');
                }else{
                    return back()->with('error', 'Please select only image for auction_image !')->withInput();
                }

                AuctionImage::create([
                    'auction_lot_id' => $auctionLot->id,
                    'image' => $auctionImage
                ]);
            }
        }

        foreach($request->product_id as $key => $id)
        {
            $product = Product::whereId($id)->first();

            if(isset($request->file('images')[$key])){
                foreach($request->file('images')[$key] as $img){

                    $allowedfileExtension = ['jpeg', 'jpg', 'png', 'svg', 'JPG', 'PNG', 'JPEG', 'SVG', 'mov', 'mp4', 'webm', 'mkv', 'MP4']; 
                    $extension = $img->getClientOriginalExtension(); 
                    if (in_array($extension, $allowedfileExtension)) { 
                        $name = "prod".str_random(5).time().'.'.$img->extension();
                        $img->move(public_path().'/storage/app/auction-images/', $name);
                        $images = "auction-images/".$name;

                        AuctionImage::create([
                            'product_id' => $id,
                            'auction_lot_id' => $auctionLot->id,
                            'image' => $images
                        ]);
                    }
                }
            }

            if($product && $product->images){
                $images = explode(',',$product->images);
                foreach($images as $img){
                    if($img != '' && !AuctionImage::whereProductId($id)->whereImage($img)->whereAuctionLotId($auctionLot->id)->first()){
                        AuctionImage::create([
                            'product_id' => $id,
                            'auction_lot_id' => $auctionLot->id,
                            'image' => $img
                        ]);
                    }
                }
            }
        }

        return redirect('/deal-spot-posted/deal-products')->with('success', 'Auction Lot updated successfully.');
    }

    public function deleteAuctionLot(Request $request)
    {
        $id = $request->input('id'); 
        if (AuctionLot::find($id)->delete()) {
            return response()->json(['status' => 'success', 'msg' => 'You have successfully deleted Auction Lot']);
        } else {
            return response()->json(['status' => 'error', 'msg' => 'Sorry there is an error in deleting Auction Lot. Please try again later!']);
        }
    }

    public function deleteAuctionImage(Request $request)
    {
        if (AuctionImage::find($request->id)->delete()) {
            return response()->json(['status' => true, 'msg' => 'You have successfully deleted Image']);
        } else {
            return response()->json(['status' => false, 'msg' => 'Sorry there is an error in deleting Image. Please try again later!']);
        }
    }

    public function auctionBid(Request $request)
    {
        $formData = request()->except(['_token', 'custom_bid_amount']);
        $auctionLot = AuctionLot::find($request->auction_lot_id);
        $lastBid = AuctionBid::whereAuctionLotId($auctionLot->id)->latest()->first();

        if($lastBid && $lastBid->bid_amount >= $formData['bid_amount'])
        {
            return redirect()->back()->with('error', 'Bid amount is invalid !!')->withInput();
        }elseif($auctionLot && $auctionLot->start_bid > $formData['bid_amount'])
        {
            return redirect()->back()->with('error', 'Bid amount is invalid !!')->withInput();
        }elseif($auctionLot && $auctionLot->user_id == Auth::id())
        {
            return redirect()->back()->with('error', 'You can not place Bid for your Auction !!');
        }elseif(AuctionBid::whereAuctionLotId($auctionLot->id)->whereUserId(Auth::id())->whereBidAmount($formData['bid_amount'])->first())
        {
            return redirect()->back()->with('error', 'You already placed Bid for this Auction Product(s) with same Bid amount !!')->withInput();
        }

        if($request->custom_bid_amount != null)
        {
            $formData['bid_amount'] = $request->custom_bid_amount;
        }

        $formData['user_id'] = Auth::id();

        $bid = AuctionBid::create($formData);

        $auctionLot->user->notify(new BidPlacedNotification($bid));

        return redirect()->back()->with('success', 'Your bid placed successfully !!');
    }

    public function bids($status = null)
    {
        $openBids = AuctionBid::whereUserId(Auth::id())->whereStatus('Open')->orderBy('id', 'desc')->get();
        $wonBids = AuctionBid::whereUserId(Auth::id())->whereStatus('Won')->orderBy('id', 'desc')->get();
        $lostBids = AuctionBid::whereUserId(Auth::id())->whereStatus('Lost')->orderBy('id', 'desc')->get();

        $auctionLots = AuctionLot::whereUserId(Auth::id())->whereNull('product_id')->get();        

        return view('front-user.deal-spot-submitted', compact('openBids', 'wonBids', 'lostBids', 'auctionLots', 'status'));
    }

    public function sellerBids($status = null)
    {
        $openBids = AuctionBid::whereHas('auctionLot', function($q){
                $q->whereUserId(Auth::id())->orWhere('user_id', Auth::user()->parent_id)
                ->orWhereHas('user', function($q){
                    $q->where('parent_id', Auth::id());
                });
        })->whereStatus('Open')->orderBy('id', 'desc')->get();
        $wonBids = AuctionBid::whereHas('auctionLot', function($q){
                $q->whereUserId(Auth::id())->orWhere('user_id', Auth::user()->parent_id)
                ->orWhereHas('user', function($q){
                    $q->where('parent_id', Auth::id());
                });
        })->whereStatus('Won')->orderBy('id', 'desc')->get();
        $lostBids = AuctionBid::whereHas('auctionLot', function($q){
                $q->whereUserId(Auth::id())->orWhere('user_id', Auth::user()->parent_id)
                ->orWhereHas('user', function($q){
                    $q->where('parent_id', Auth::id());
                });
        })->whereStatus('Lost')->orderBy('id', 'desc')->get();

        $auctionLots = AuctionLot::where(function($q){
            $q->whereUserId(Auth::id())->orWhere('user_id', Auth::user()->parent_id) 
            ->orWhereHas('user', function($q){
                $q->where('parent_id', Auth::id());
            });
        })->whereNull('product_id')->orderBy('id', 'desc')->get();        

        return view('front-user.deal-spot-posted', compact('openBids', 'wonBids', 'lostBids', 'auctionLots', 'status'));
    }

    public function getBid(Request $request)
    {
        $bid = AuctionBid::find($request->id);
        if($bid){
            Session::forget('rfq');
            Session::forget('order');
            Session::forget('bid');
            Session::put('bid', $bid);
            
            return response([
                'status' => true,
                'pageData' => \View::make('front-user.bid-shipping-modal')->render(),
            ]);
        }else{
            return response([
                'status' => false,
            ]);
        }
       
    }

    public function saleProduct(Request $request)
    {
        $product = Product::find($request->product_id);
       
        if($product)
        {
            if($product->price > 0 && $product->price < $request->sale_price)
            {
                return redirect()->back()->with('error', 'Sale Price should be less than the Product Price.')->withInput();
            }

            $product->is_on_sale = true;
            $product->sale_price = $request->sale_price;
            $product->save();
           
            $request->sale_end_date = carbon::parse($request->sale_end_date)->addDays(1);

            if($auctionLot = AuctionLot::whereProductId($product->id)->first())
            {
                $auctionLot->update([
                    'user_id' => Auth::id(),
                    'product_id' => $product->id,
                    'lot_name' => $product->name,
                    'location' => $product->location,
                    'description' => $product->description,
                    'specification' => $product->specification,
                    'lead_time' => $product->lead_time,
                    'price' => $product->price,
                    'bid_date' => $request->sale_end_date
                ]);
            }else{
                AuctionLot::create([
                    'user_id' => Auth::id(),
                    'product_id' => $product->id,
                    'lot_name' => $product->name,
                    'location' => $product->location,
                    'description' => $product->description,
                    'specification' => $product->specification,
                    'lead_time' => $product->lead_time,
                    'price' => $product->price,
                    'bid_date' => $request->sale_end_date
                ]);
            }

            return redirect('/classified-products')->with('success', 'Product Succesfully Listed for Sale.');
        }else{
            return redirect()->back()->with('error', 'Something went wrong.')->withInput();
        }

    }

   public function buyerContactAdmin(Request $request)
   {
        // dd($request->all());
        $seller = User::find($request->seller_id);
        $rfq = Rfq::whereId($request->rfq_id)->first();
        $admin = User::where('user_type', 'admin')->first();

        $admin->notify(new BuyerContactAdmin($rfq, $seller, $request->comment));

        return redirect()->back()->with('success', 'Admin will notify seller shortly for your RFQ Response.');
   } 

   public function rejectQuotation(Request $request)
   {
        $sellerResponse = SellerRfqRespond::whereId($request->response_id)->first();

        if($sellerResponse){
            $sellerResponse->status = 'Reject';
            $sellerResponse->save();
    
            $sellerResponse->user->notify(new QuotationRejection($sellerResponse));
    
            return redirect()->back()->with('success', 'Quotation rejected successfully.');
        }else{
            return redirect()->back()->with('error', 'Something went wrong.')->withInput();
        }
      
        
   }

   public function saveCard(Request $request)
   {
        $this->validate($request, [
            'card_holder_name' => ['required', 'string'],
            'card_number' => ['required', 'numeric'],
            'cvv' => ['required', 'numeric'],
            'expiry' => ['required', 'string'],
            'zipcode' => ['required', 'numeric'],
        ]);

        UserCred::create([
            'user_id' => Auth::id(),
            'name' => $request->card_holder_name,
            'card' => $request->card_number,
            'cvv' => $request->cvv,
            'expiry' => $request->expiry,
            'zipcode' => $request->zipcode
        ]);

        return redirect()->back()->with('success', 'Your card saved successfully..');
   }

   public function bulkProductDelete(Request $request)
   { 
       $msg = false;
       $status = false;
        foreach($request->get_button_click_id as $id){
            $orderCount = OrderProduct::whereProductId($id)->whereIn('status', ['pending', 'Dispatched', 'On the way'])->count();
            
            $rfqCount = Rfq::whereHas('products', function($q)use($id){
                $q->whereId($id)->whereIn('status', ['Packed', 'Dispatched for Shipping', 'On the Way']);
            })->count();
            $shipperRfqCount = ShipperRfqResponse::whereProductId($id)->whereIn('status', ['Packed', 'Dispatched for Shipping', 'On the Way'])->count();
            // dd($orderCount > 0 || $rfqCount > 0 || $shipperRfqCount > 0);
            if($orderCount > 0 || $rfqCount > 0 || $shipperRfqCount > 0){
                $msg = 'Some products are not deleted as procurement process is not completed.';
            }else{
                Product::where('id', $id)->delete();
                $msg = 'Products Deleted Successfully';
            }

            $status = true;
           
        }

        if ($status == true) {
            return response()->json([
                'status' => 'success',
                'msg' => $msg
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'msg' => $msg
            ]);
        }
   }

   public function saleProducts()
   {
   
        $auctionLots = AuctionLot::whereUserId(Auth::id())->whereStatus('Open')->whereNotNull('product_id')
                        ->where(DB::raw("(DATE_FORMAT(auction_lots.bid_date,'%Y-%m-%d'))"), '>=', Carbon::now()->addDays(1)->format('Y-m-d'))
                        ->orderBy('id', 'Desc')->paginate(10);

        return view('front-user.sale-products', compact('auctionLots'));
   }

   public function editSaleProduct($id)
   {
   
        $auction = AuctionLot::find($id);
        if($auction){
            $row = $auction->product;
        }else{
            return redirect()->back()->with('error', 'Something went wrong');
        }

        $membershipProduct = UserMembershipPlan::where('user_id', Auth::id())->whereStatus('Active')->first(); 
        $category = ProductCategory::get();
        $companies = Company::whereStatus(1)->orderBy('name', 'ASC')->get();
        $nmfcCodes = NmfcCode::orderBy('nmfc_code', 'ASC')->get();
        $url = url('product-detail', $row->id);
        $seo = SeoContent::whereRoute($url)->first();


        return view('front-user.edit-sale-product', compact('row', 'seo', 'membershipProduct', 'category', 'companies', 'nmfcCodes', 'auction'));
   }

   public function updateSaleProduct($id, Request $request)
   {
    $formData = request()->except(['_token', 'new_nmfc_code', 'sale_end_date', 'meta_title', 'meta_description', 'meta_keywords']);  
    // dd($formData);
    $this->validate($request, [
        'name' => ['required', 'string', 'max:255'], 
        // 'images' => ['mimes:jpeg,jpg,png,svg,mov,mp4,webm,mkv'], 
    ], [
        "name.required" => "Please enter :attribute", 
        "images.mimes" => "Please enter valid product image", 
    ]);

    $auctionLot = AuctionLot::whereId($id)->first();
    if($auctionLot){
        $product =  Product::whereId($auctionLot->product_id)->first();
            if($product){
                $formData['user_id'] = Auth::user()->id; 
                $nmfc_code = null;
                if( isset($request->nmfc_code) && $request->nmfc_code == 'other' && isset($request->new_nmfc_code) && $request->new_nmfc_code != null)
                {
                    $nmfcExist = NmfcCode::whereNmfcCode($request->new_nmfc_code)->first();
                    if(! $nmfcExist){
                        $nmfc = NmfcCode::create([
                            'nmfc_code' => $request->new_nmfc_code
                        ]);

                        $formData['nmfc_code']  = $nmfc->nmfc_code;
                    }else{
                        $formData['nmfc_code']  = $nmfcExist->nmfc_code;
                    }
                }elseif(isset($request->nmfc_code)){
                    $formData['nmfc_code']  = $request->nmfc_code;
                }

                if(isset($request->company_id) && $request->company_id != 'other')
                {
                    $company = Company::whereName($request->company_id)->first();
                    
                    if($company){
                        $formData['company_id'] = $company->id;
                    }
                }

                if(isset($request->new_company_name))
                {
                    $companyExist = Company::whereName($request->new_company_name)->first();

                    if(! $companyExist){
                        $company = Company::create([
                            'name' => $request->new_company_name,
                            'size' => $request->company_size,
                            'revenue' => $request->revenue,
                        ]);

                        $formData['company_id'] = $company->id;
                    }else{
                        $formData['company_id'] = $companyExist->id;
                    }
                }


                // if ($request->hasFile('images')) {
                //     $allowedfileExtension = ['jpeg', 'jpg', 'png', 'svg', 'JPG', 'PNG', 'JPEG', 'SVG'];
                //     $file = $request->file('images'); 
                //     $extension = $file->getClientOriginalExtension(); 
                //     if (in_array($extension, $allowedfileExtension)) { 
                //         $formData['images'] = $file->store('product-images');
                //     }
                // }

                // save the row to the database
                $duplicateEntry = Product::whereName($formData['name'])->first();
                if ($request->hasFile('specification')) {
                    $allowedfileExtension = ['jpeg', 'jpg', 'png', 'svg'];
                    $file = $request->file('specification');
                    File::delete($duplicateEntry->specification);

                    $extension = $file->getClientOriginalExtension();

                    if (in_array($extension, $allowedfileExtension)) {

                        $formData['specification'] = $file->store('specifications');
                    }else{
                        return back()->with('error', 'Please select only image for specification !')->withInput();
                    }
                }
                
                $uploadedMedias=''; 
                if($request->hasfile('images')){
                    foreach($request->file('images') as $file){
                        if($file != ''){
                            $allowedfileExtension = ['jpeg', 'jpg', 'png', 'svg', 'JPG', 'PNG', 'JPEG', 'SVG', 'mov', 'mp4', 'webm', 'mkv', 'MP4']; 
                            $extension = $file->getClientOriginalExtension(); 
                            if (in_array($extension, $allowedfileExtension)) { 
                                $name = "prod".str_random(5).time().'.'.$file->extension();
                                $file->move(public_path().'/storage/app/product-images/', $name);
                                $uploadedMedias .= "product-images/".$name.",";
                            }else{
                                return back()->with('error', 'Please select only image or videos for product images/videos !')->withInput();
                            }
                        }
                    }
                }
                $formData['images'] = substr_replace($uploadedMedias,'',-1);

                
                if ($request->buy_america_compliant != 'yes') {
                    $formData['buy_america_compliant'] = '';
                }

                if ($request->product_type != 'new') {
                    $formData['product_type'] = '';
                }

                if (! isset($request->is_freight_included)) {
                    $formData['is_freight_included'] = 0;
                }

                if(isset($formData['category_id'])){
                    $formData['category_id'] = implode(',', $formData['category_id']);
                }

                if (! isset($request->is_rfq)) {
                    $formData['is_rfq'] = 0;
                }
                // if ($duplicateEntry == '' || ($duplicateEntry != '' && $duplicateEntry->id == $id)) {

                if($product->images != null)
                {
                    $images = explode(',', $product->images);
                    if($formData['images'] != ''){
                        $newImages = explode(',', $formData['images'] );
                
                        $mergeImage =  array_merge($images, $newImages);

                        $formData['images'] = implode(',', $mergeImage);
                    }else{
                        $formData['images'] = $product->images;
                    }
                }
                
                if($product->bid_days != $formData['bid_days']){
                    $days = $formData['bid_days'] - $product->bid_days ;

                    $formData['bid_date'] = Carbon::parse($product->bid_date)->addDays($days + 1);
                }


                $product->update($formData);
            
                $url = url('product-detail', $product->id);
                $seo = SeoContent::whereRoute($url)->first();
              
                if($seo)
                {
                    $seo->update([
                        'title' =>$request->meta_title,
                        'description' => $request->meta_description,
                        'keywords' => $request->meta_keywords
                    ]);
                }else{
                    if($request->meta_title){
                        SeoContent::create([
                            'title' =>$request->meta_title,
                            'description' => $request->meta_description,
                            'keywords' => $request->meta_keywords,
                            'route' => $url
                        ]);
                    }
                }

                $request->sale_end_date = carbon::parse($request->sale_end_date)->addDays(1);

                $auctionLot->price = $request->sale_price;
                $auctionLot->bid_date = $request->sale_end_date;
                $auctionLot->save();

                return redirect('/classified-products')->with('success', 'Classified Products Updated Successfully');
            }else{
                return redirect()->back()->with('error', 'Something Went Wrong !')->withInput();
            }
        }else{
            return redirect()->back()->with('error', 'Something Went Wrong !')->withInput();
        }
   }

   public function removeSaleProduct(Request $request)
   {
        $auctionLot = AuctionLot::whereId($request->id)->first();
        $auctionLot->status = "Closed";
        $auctionLot->save();

        $auctionLot->product->is_on_sale = false;
        $auctionLot->bid_date = carbon::now();
        $auctionLot->product->save();
        $id = $auctionLot->product_id;
        
        $product = Product::where('id', $auctionLot->product_id)->first();
        $product->is_on_sale = false;
        $product->save();

        $orderCount = OrderProduct::whereProductId($id)->whereIn('status', ['pending', 'Dispatched', 'On the way'])->count();
            
        $rfqCount = Rfq::whereHas('products', function($q)use($id){
            $q->whereId($id)->whereIn('status', ['Packed', 'Dispatched for Shipping', 'On the Way']);
        })->count();
        $shipperRfqCount = ShipperRfqResponse::whereProductId($id)->whereIn('status', ['Packed', 'Dispatched for Shipping', 'On the Way'])->count();
        // dd($orderCount > 0 || $rfqCount > 0 || $shipperRfqCount > 0);
        if($orderCount > 0 || $rfqCount > 0 || $shipperRfqCount > 0){
            $msg = 'Auction is closed but product is not deleted as procurement process is not completed.';

            return response()->json(['status' => 'error', 'msg' => 'Sorry there is an error in deleting Product as procurement process is not completed. Please try again later!']);
        }else{
            Product::where('id', $auctionLot->product_id)->delete();

            return response()->json(['status' => 'success', 'msg' => 'You have successfully removed from Sale']);
        }
   }

   public function editRfq($id, Request $request)
    {
        $rfq = Rfq::where('id',$id)->first(); 

        $categories = ProductCategory::get();
        $response = SellerRfqRespond::whereRfqId($id)->whereSellerId(Auth::id())->first();
        $nmfcCodes = NmfcCode::orderBy('nmfc_code', 'ASC')->get();

        return view('front-user.edit-rfq', compact('rfq','categories', 'response', 'nmfcCodes'));  
    }

    public function updateRfq($id, Request $request)
    {
        $formData = request()->except(['_token','images', 'due_by', 'user_id','category_id','name','description', 'product_weight','product_length','product_width','product_height','price','quantity' ,'unit','hazmat','oversize','load_type' ,'rfq', 'unit_price']); 

        if(isset($request->buy_america_compliant)){
            $formData['buy_america_compliant'] = $request->buy_america_compliant;
        }else{
            $formData['buy_america_compliant'] = 'no';
        }

        if(isset($request->make_public)){
            $formData['make_public'] = $request->make_public;
        }else{
            $formData['make_public'] = 'no';
        }
        
        if(isset($request->separate_shipping)){
            $formData['separate_shipping'] = $request->separate_shipping;
        }else{
            $formData['separate_shipping'] = 'no';
        }

        $rfqImages = [];
        $rfq = Rfq::where('id',$id)->first(); 
        $rfq->update($formData); 
        $i = 0; 
        
        foreach($request->product_ids as $id){  
            $product = Product::whereId($id)->first();

            $uploadedMedias=''; 
                
                if(isset($request->file('images')[$i])){
                    foreach($request->file('images')[$i] as $file){
                        if(is_file($file)){
            
                            $allowedfileExtension = ['jpeg', 'jpg', 'png', 'svg', 'JPG', 'PNG', 'JPEG', 'SVG']; 
                            $extension = $file->getClientOriginalExtension(); 
                            if (in_array($extension, $allowedfileExtension)) { 
                                $name = "prod".str_random(5).time().'.'.$file->extension();
                                $file->move(public_path().'/storage/app/product-images/', $name);
                                $uploadedMedias .= "product-images/".$name.",";
                                $rfqImages [] = "product-images/".$name;
                            }
                        }
                    }
                }
                $productImages = substr_replace($uploadedMedias,'',-1); 
                if($product->images != null || $productImages != '')
                {
                    $images = explode(',', $product->images);
                   
                        $newImages = explode(',', $productImages );
                   
                        $mergeImage =  array_merge($images, $newImages);
    
                        $productImages = implode(',', array_filter($mergeImage));
                    
                }else{
                        $productImages = $product->images;
                } 

                
            $uploadedSpecs=''; 
                
            if(isset($request->file('specification')[$i])){
                foreach($request->file('specification')[$i] as $file){
                    if(is_file($file)){
            
                        $allowedfileExtension = ['jpeg', 'jpg', 'png', 'svg', 'JPG', 'PNG', 'JPEG', 'SVG']; 
                        $extension = $file->getClientOriginalExtension(); 
                        // if (in_array($extension, $allowedfileExtension)) { 
                            $name = "prod".str_random(5).time().'.'.$file->extension();
                            $file->move(public_path().'/storage/app/product-images/', $name);
                            $uploadedSpecs .= "product-images/".$name.",";
                        // }
                    }
                }
            }
            
            $productSpecs = substr_replace($uploadedSpecs,'',-1); 
            if($product->specification != null || $productImages != '')
            {
                $images = explode(',', $product->specification);
               
                    $newSpecs = explode(',', $productImages );
               
                    $mergeSpecs =  array_merge($images, $newSpecs);

                    $productSpecs = implode(',', array_filter($mergeSpecs));
            }else{
                $productSpecs = $product->specification;
            }

            // if (isset($request->file('specification')[$i])) { 
            //     $file = $request->file('specification')[$i];

            //     $extension = $file->getClientOriginalExtension(); 

            //     $specification = $file->store('specifications'); 
            // }else{
            //     $specification = $product->specification;
            // }


            if(isset($request->category_id[$i])){
                $category_id = implode(',', $request->category_id[$i]);
            }else{
                $category_id = $product->category_id;
            }

            $nmfc_code = null;
            if( isset($request->nmfc_code[$i]) && $request->nmfc_code[$i] == 'other' && isset($request->new_nmfc_code[$i]) && $request->new_nmfc_code[$i] != null)
            {
                $nmfcExist = NmfcCode::whereNmfcCode($request->new_nmfc_code[$i])->first();
                if(! $nmfcExist){
                    $nmfc = NmfcCode::create([
                        'nmfc_code' => $request->new_nmfc_code[$i]
                    ]);
                
                    $nmfc_code  = $nmfc->nmfc_code;
                }else{
                    $nmfc_code  = $nmfcExist->nmfc_code;
                }
            }elseif(isset($request->nmfc_code[$i])){
                $nmfc_code = $request->nmfc_code[$i];
            }
            $images = $product->images;

            $productData = array(
                'user_id' => Auth::user()->id,
                'category_id' => $category_id,
                'name' => $request->name[$i], 
                'description' => $request->description[$i], 
                'buy_america_compliant' => $request->buy_america_compliant, 
                'product_weight' => $request->product_weight[$i],
                'product_length' => $request->product_length[$i],
                'product_width' => $request->product_width[$i],
                'product_height' => $request->product_height[$i],
                'price' => $request->price[$i], 
                'quantity' => $request->quantity[$i], 
                // 'unit' => $request->unit[$i], 
                'lead_time' => isset($request->lead_time[$i])?$request->lead_time[$i]:null, 
                'hazmat' => isset($request->hazmat[$i])?$request->hazmat[$i]:'no',
                'oversize' => isset($request->oversize[$i])?$request->oversize[$i]:'no',
                'product_type' => isset($request->product_type[$i])?$request->product_type[$i]:'used',
                'load_type' => isset($request->load_type[$i])?$request->load_type[$i]:null,
                'rfq' => $rfq->id,
                'freight_class' => isset($request->freight_class[$i]) ? $request->freight_class[$i] : ' ' , 
                'nmfc_code' => $nmfc_code,
                'packaging' =>isset($request->packaging[$i]) ? $request->packaging[$i] : '' ,
                'specification' => $productSpecs,
                'images' => $productImages
            ) ;    

            $product->update($productData);
            $i++;
        }

        if($rfq->images != null)
        {
            $images = explode(',', $rfq->images);
            if(count($rfqImages ) > 1){
                $newImages = $rfqImages;
           
                $mergeImage =  array_merge($images, $newImages);

                $rfqImages = implode(',', $mergeImage);
            }else{
                $rfqImages = $rfq->images;
            }

            $rfq->images = $rfqImages;
            $rfq->save();
        }else{
            $rfq->images = implode(',', $rfqImages);
            $rfq->save();
        }

        return redirect('RFQ-spot-submitted')->with('success', 'Rfqs updated successfully.');
    }

    public function deleteRfqImage(Request $request)
    {
        $product = Product::find($request->id);

        if($product)
        {
            $images = explode(',', str_replace(' ', '', $product->images));

            // if(in_array($request->image, $images))
            // {
            //     unset($request->image);

            //     $product->images = implode(',', $images);
            //     $product->save();
            // }
            foreach($images as $key => $image)
            {
                if($image == $request->image){
                    unset($images[$key]);
                    $product->images = implode(',', $images);
                    $product->save();
                }
            }
            $rfq = Rfq::whereId($product->rfq)->first();

            $rfqImages = explode(',', $rfq->images);
            foreach($rfqImages as $key => $image)
            {
                if($image == $request->image){
                    unset($rfqImages[$key]);
                    $rfq->images = implode(',', $rfqImages);
                    $rfq->save();
                }
            }

           return response([
            'status' => true,
            'msg' => 'Image deleted successfully.'
           ]);
        }else{
            return response([
                'status' => false,
                'msg' => 'Something went wrong'
               ]);
        }
      
    }
    
    public function deleteCertificateImage(Request $request)
    {
        $rfq = UserCertificate::find($request->id);

        if($rfq)
        {   
            File::delete($rfq->image);     
            $rfq->delete();   

            return response([
                'status' => true,
                'msg' => 'Certificate deleted successfully.'
            ]);
        }else{
            return response([
                'status' => false,
                'msg' => 'Something went wrong'
            ]);
        }
    }

    public function createSaleProduct()
    {
        $membershipProduct = UserMembershipPlan::where('user_id', Auth::id())->whereStatus('Active')->first(); 
        $category = ProductCategory::get();
        $companies = Company::whereStatus(1)->orderBy('name', 'ASC')->get();
        $nmfcCodes = NmfcCode::orderBy('nmfc_code', 'ASC')->get();

        return view('front-user.create-sale', compact('category','companies','nmfcCodes','membershipProduct')); 
    }

    public function saveSaleProduct(Request $request)
    {
        $formData = request()->except(['_token', 'new_nmfc_code', 'sale_end_date', 'meta_title', 'meta_description', 'meta_keywords']);  
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'], 
            // 'images' => ['mimes:jpeg,jpg,png,svg,mov,mp4,webm,mkv'], 
        ], [
            "name.required" => "Please enter :attribute", 
            "images.mimes" => "Please enter valid product image", 
        ]);
        $formData['user_id'] = Auth::id(); 
        $nmfc_code = null;
        if( isset($request->nmfc_code) && $request->nmfc_code == 'other' && isset($request->new_nmfc_code) && $request->new_nmfc_code != null)
        {
            $nmfcExist = NmfcCode::whereNmfcCode($request->new_nmfc_code)->first();
            if(! $nmfcExist){
                $nmfc = NmfcCode::create([
                    'nmfc_code' => $request->new_nmfc_code
                ]);
    
                $formData['nmfc_code']  = $nmfc->nmfc_code;
            }else{
                $formData['nmfc_code']  = $nmfcExist->nmfc_code;
            }
          
        }elseif(isset($request->nmfc_code)){
            $formData['nmfc_code']  = $request->nmfc_code;
        }

        if(isset($request->company_id) && $request->company_id != 'other')
        {
            $company = Company::whereName($request->company_id)->first();
            
            if($company){
                $formData['company_id'] = $company->id;
            }
        }

        if(isset($request->new_company_name))
        {
            $companyExist = Company::whereName($request->new_company_name)->first();

            if(! $companyExist){
                $company = Company::create([
                    'name' => $request->new_company_name,
                    'size' => $request->company_size,
                    'revenue' => $request->revenue,
                ]);

                $formData['company_id'] = $company->id;
            }else{
                $formData['company_id'] = $companyExist->id;
            }
        }

        if ($request->hasFile('specification')) {
            $allowedfileExtension = ['jpeg', 'jpg', 'png', 'svg'];
            $file = $request->file('specification');

            $extension = $file->getClientOriginalExtension();

            if (in_array($extension, $allowedfileExtension)) {

                $formData['specification'] = $file->store('specifications');
            }else{
                return back()->with('error', 'Please select only image for specification !')->withInput();
            }
        }
        
        $uploadedMedias=''; 
        if($request->hasfile('images')){
            foreach($request->file('images') as $file){

                if($file != ''){
                    $allowedfileExtension = ['jpeg', 'jpg', 'png', 'svg', 'JPG', 'PNG', 'JPEG', 'SVG', 'MOV', 'MP4', 'webm', 'mkv', 'mp4']; 
                    $extension = $file->getClientOriginalExtension(); 
                    if (in_array($extension, $allowedfileExtension)) { 
                        $name = "prod".str_random(5).time().'.'.$file->extension();
                        $file->move(public_path().'/storage/app/product-images/', $name);
                        $uploadedMedias .= "product-images/".$name.",";
                    }else{
                        return back()->with('error', 'Please select only image or videos for product images/videos !')->withInput();
                    }
                }
            }
        }
        $formData['images'] = substr_replace($uploadedMedias,'',-1); 

        // if ($request->hasFile('images')) {
        //     $allowedfileExtension = ['jpeg', 'jpg', 'png', 'svg', 'JPG', 'PNG', 'JPEG', 'SVG'];
        //     $file = $request->file('images'); 
        //     $extension = $file->getClientOriginalExtension(); 
        //     if (in_array($extension, $allowedfileExtension)) { 
        //         $formData['images'] = $file->store('product-images');
        //     }
        // } 

        if($request->product_type == '' ){  
            $formData['product_type'] = 'used';
        }

        if(isset($formData['category_id'])){
            $formData['category_id'] = implode(',', $formData['category_id']);
        }
        $formData['is_on_sale'] = 1;

        $product = Product::create($formData); 
       
        $request->sale_end_date = carbon::parse($request->sale_end_date)->addDays(1);

        AuctionLot::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'lot_name' => $product->name,
            'location' => $product->location,
            'description' => $product->description,
            'specification' => $product->specification,
            'lead_time' => $product->lead_time,
            'price' => $product->price,
            'bid_date' => $request->sale_end_date
        ]);

        $url = url('product-detail', $product->id);

        if($request->meta_title){
            SeoContent::create([
                'title' =>$request->meta_title,
                'description' => $request->meta_description,
                'keywords' => $request->meta_keywords,
                'route' => $url
            ]);
        }
        if ($product->save()) {
            return redirect('/classified-products')->with('success', 'Product   added successfully.');
        } else {
            return redirect('/classified-products')->with('error', 'Sorry there is an error while adding Product. please try again.')->withInput();
        }   
    }

    public function userInquiry(Request $request){
        
        $this->validate($request, [
            'query' => ['required', 'string', 'max:255'],
        ], [
            "query.required" => "Please enter :attribute", 
        ]); 

        $formData = request()->except(['_token']);

        $product = Product::whereId($formData['product_id'])->first();

        if($product){
            if(Auth::id() == $product->user_id){
                return redirect()->back()->with('error', 'You can not post inquiry for your own product');
            }

            $inquiry = UserInquiry::create([
                'user_id' => Auth::id(),
                'seller_id' => $product->user_id,
                'product_id' => $product->id,
                'query' => $formData['query']
            ]);

            @$product->user->notify(new InquiryFromBuyerNotification($inquiry));

            return redirect()->back()->with('success', 'Your inquiry sent successfull to the seller !');
        }else{
            return redirect()->back()->with('error', 'Something went wrong !');
        }
       
    }

    public function userInquiryReply(Request $request){
        $this->validate($request, [
            'reply' => ['required', 'string', 'max:255'],
        ], [
            "reply.required" => "Please enter :attribute", 
        ]); 

        $formData = request()->except(['_token']);

        $inquiry = UserInquiry::whereId($formData['inquiry_id'])->first();

        if($inquiry){
            $inquiry->reply = $formData['reply'];
            $inquiry->save();
            
            $inquiry->user->notify(new InquiryReplyFromSellerNotification($inquiry));

            return redirect()->back()->with('success', 'Your reply sent successfull to the buyer !');
        }else{
            return redirect()->back()->with('error', 'Something went wrong !');
        }
       
    }

    public function inquiries()
    {
        $inquiries = UserInquiry::whereUserId(Auth::id())->orWhere('seller_id', Auth::id())->get();

        return view('front-user.inquiries', compact('inquiries'));
    }

    public function createRfq($id = null)
    {
        $products = Product::leftjoin('product_categories', 'product_categories.id', '=', 'products.category_id')
        ->leftjoin('featured_products', 'featured_products.product_id', '=', 'products.id')
        ->leftjoin('rating_review_products','rating_review_products.product_id', '=', 'products.id')
        ->where('products.rfq', '=', null)->where('products.is_on_sale', 0)
        ->where('products.user_id', '!=', null)
        // ->where('products.buying_format', '=', 'Buy Now')
        ->select('products.*','product_categories.name as category_name','featured_products.id as featured',DB::raw('(AVG(rating_review_products.rating)) AS average_rating'), DB::raw('COUNT(rating_review_products.id) AS total_rating' ) )
        ->groupBy('products.id')
        ->orderBy('products.id', 'desc')
        ->get(); 

        $categories = ProductCategory::orderBy('name', 'ASC')->get(); 
        $states = State::get('name');

        return view('front-user.pages.new-rfq', compact('products', 'categories', 'states', 'id'));
    }

    public function deleteSpecification(Request $request)
    {
        $product = Product::find($request->id);

        if($product)
        {
           $product->specification = null;
           $product->save();

           return response([
            'status' => true,
            'msg' => 'Specification deleted successfully.'
           ]);
        }else{
            return response([
                'status' => false,
                'msg' => 'Something went wrong'
               ]);
        }
      
    }

    public function deleteRfqSpecification(Request $request)
    {
        $product = Product::find($request->id);

        if($product)
        {
           $product->specification = null;
           $product->save();

           return response([
            'status' => true,
            'msg' => 'Specification deleted successfully.'
           ]);
        }else{
            return response([
                'status' => false,
                'msg' => 'Something went wrong'
               ]);
        }
      
    }

    public function webhook(Request $request)
    {
        if (isset($_SERVER['HTTP_INTUIT_SIGNATURE']) && !empty($_SERVER['HTTP_INTUIT_SIGNATURE'])) {
            $payLoad = file_get_contents("php://input");
            if ($this->isValidJSON($payLoad)) {
                $payloadHash = hash_hmac('sha256', $payLoad, $webhook_token);
                $singatureHash = bin2hex(base64_decode($_SERVER['HTTP_INTUIT_SIGNATURE']));
                if($payloadHash == $singatureHash) {
                    // verified....OK
                    $is_verified = true;
                    $payLoad_data = json_decode($payLoad, true);
                    foreach ($payLoad_data['eventNotifications'] as $event_noti) {
                        $realmId = $event_noti['realmId'];	//	this is your company-ID from Intuit
                        // now do whatever you want to do with data received from Intuit...
                        foreach($event_noti['dataChangeEvent']['entities'] as $entries) {
                           QbWebhook::create([
                            'notification' => $entries,
                           ]);
                        }
                    }
                } else {
                    // not verified
                }
            }
        }
    }

    public  function isValidJSON($string) {
        if (!isset($string) || trim($string) === '') {
            return false;
        }
    
        json_decode($string);
        if (json_last_error() != JSON_ERROR_NONE) {
            return false;
        }
        return true;
    }

    public function saveRfqImages(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = public_path('/storage/app/product-images/');
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $name = uniqid() . '_' . trim($file->getClientOriginalName());
            $mime = $file->getClientMimeType();

            if ($mime == 'image/jpeg') {
                $image = @ImageCreateFromJpeg($file);
            } elseif ($mime == 'image/png') {
                $image = imagecreatefrompng($file);
            }

            if (isset($image) && $image != false) {
                imagejpeg($image, $path . '/' . $name, '50');
            } else {
                $file->move($path, $name);
            }

            // $name = 'provider_service/'.$name;

            return response()->json([
                'name' => 'product-images/'.$name,
                'type' => $mime,
            ]);
        }
    }

    public function deleteRfqImages(Request $request)
    {
        if (file_exists(public_path('/storage/app/product-images/') . '/' . $request->name)) {
            File::delete(public_path('/storage/app/product-images/') . '/' . $request->name);
        }

        return response()->json(['status' => 'success', 'msg' => 'You have successfully deleted image']);
    }

    public function saveRfqSpecification(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = public_path('/storage/app/product-images/');
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $name = uniqid() . '_' . trim($file->getClientOriginalName());
            $mime = $file->getClientMimeType();

            if ($mime == 'image/jpeg') {
                $image = @ImageCreateFromJpeg($file);
            } elseif ($mime == 'image/png') {
                $image = imagecreatefrompng($file);
            }

            if (isset($image) && $image != false) {
                imagejpeg($image, $path . '/' . $name, '50');
            } else {
                $file->move($path, $name);
            }

            // $name = 'provider_service/'.$name;

            return response()->json([
                'name' => $name,
                'type' => $mime,
            ]);
        }
    }

    public function deleteRfqSpecifications(Request $request)
    {
        $product = Product::find($request->id);

        if($product)
        {
            $images = explode(',', str_replace(' ', '', $product->specification));

            // if(in_array($request->image, $images))
            // {
            //     unset($request->image);

            //     $product->specification = implode(',', $images);
            //     $product->save();
            // }

            foreach($images as $key => $image)
            {
                if($image == $request->img){
                    unset($images[$key]);
                
                    $product->specification = implode(', ', $images);
                    $product->save();
                }
            }

           return response([
            'status' => true,
            'msg' => 'Specification deleted successfully.'
           ]);
        }else{
            return response([
                'status' => false,
                'msg' => 'Something went wrong'
               ]);
        }
    }
}