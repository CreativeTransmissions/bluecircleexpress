<div class="row"> 
    <div class="columns small-12 medium-6  bt-flabels__wrapper"> <input type="text" required name="first_name" placeholder="YOUR FIRST NAME*"><span class="bt-flabels__error-desc">Required First Name</span></div>
    <div class="columns small-12 medium-6  bt-flabels__wrapper"> <input type="text" required name="last_name" placeholder="YOUR LAST NAME*"><span class="bt-flabels__error-desc">Required Last Name</span></div> 
    
</div>
<div class="row"> 
    <div class="columns small-12 medium-6  bt-flabels__wrapper"> 
        <input type="text" required name="email" id="email" class="email-address" data-parsley-type="email" placeholder="EMAIL ADDRESS*">
        <span class="bt-flabels__error-desc">Required/Invalid Email</span>
    </div>
    <div class="columns small-12 medium-6  bt-flabels__wrapper"> 
        <input type="text" data-parsley-type="number" data-parsley-length="[6, 15]" required name="phone" class="phone" placeholder="PHONE NUMBER*"><span class="bt-flabels__error-desc">Required/Invalid Phone</span>
    </div>
</div>