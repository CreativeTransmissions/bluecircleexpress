<div class="transit_inner contact tq-form-fields-container <?php echo $hide_section; ?>" > <!-- your contact section start here -->
    <div class="transit_header tq-form-title-color">   <!-- Delivery Address section start here -->
        <h2><?php echo $this->view_labels['contact_section_title']; ?></h2>
    </div>    
    <div class="transit_body tq-form-bg-color">
        <div class="full">
            <div class="left half bt-flabels__wrapper">
                <span class="sub_title"><i class="icon icon-icn-name"></i><?php echo $this->view_labels['first_name']; ?></span>
                <input type="text" name="first_name" required data-parsley-maxlength="45" placeholder="Enter <?php echo $this->view_labels['first_name']; ?>" value="<?php echo $this->customer['first_name']?>">
                <span class="bt-flabels__error-desc">Required / Invalid <?php echo $this->view_labels['first_name']; ?></span>
            </div>
            <div class="right half bt-flabels__wrapper">
                <span class="sub_title"><i class="icon icon-icn-name"></i><?php echo $this->view_labels['last_name']; ?></span>
                <input type="text" name="last_name" required  data-parsley-maxlength="45" placeholder="Enter <?php echo $this->view_labels['last_name']; ?>"  value="<?php echo $this->customer['last_name']?>">
                <span class="bt-flabels__error-desc">Required / Invalid <?php echo $this->view_labels['last_name']; ?></span>
            </div>
        </div>
        <div class="full">
            <div class="left half bt-flabels__wrapper">
                <span class="sub_title"><i class="icon icon-icn-phone-number"></i><?php echo $this->view_labels['phone']; ?></span>
                <input type="text" data-parsley-type="number" required name="phone" class="phone" data-parsley-maxlength="45" placeholder="Enter your <?php echo $this->view_labels['phone']; ?>"  value="<?php echo $this->customer['phone']?>">
                <span class="bt-flabels__error-desc">Required / Invalid <?php echo $this->view_labels['phone']; ?></span>
            </div>
            <div class="right half bt-flabels__wrapper">
                <span class="sub_title"><i class="icon icon-icn-email"></i><?php echo $this->view_labels['email']; ?></span>
                <input type="text" data-parsley-type="email" name="email" required data-parsley-maxlength="128" placeholder="Enter your <?php echo $this->view_labels['email']; ?>"  value="<?php echo $this->customer['email']?>">
                <span class="bt-flabels__error-desc">Required / Invalid <?php echo $this->view_labels['email']; ?></span>
            </div>
        </div>
        <div class="full bt-flabels__wrapper">
            <span class="sub_title">
                <i class="icon icon-icn-description"></i><?php echo $this->view_labels['job_info_label']; ?>
            </span>
            <textarea tabindex="5" name="description" id="description" placeholder="Enter <?php echo $this->view_labels['job_info_label']; ?>"></textarea>
            <span class="bt-flabels__error-desc">Required / Invalid </span>
        </div>
    </div>
</div> <!-- your contact section end here -->
           