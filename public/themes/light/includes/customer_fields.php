<div class="transit_inner contact tq-form-fields-container <?php echo $hide_section; ?>" > <!-- your contact section start here -->
    <div class="transit_header tq-form-title-color">   <!-- Delivery Address section start here -->
        <h2><?php echo $this->view_labels['contact_section_title']; ?></h2>
    </div>
    <div class="transit_body tq-form-bg-color">
        <div class="full">
            <div class="left half bt-flabels__wrapper">
                <span class="sub_title"><i class="icon icon-icn-name"></i><?php echo $this->view_labels['first_name_label']; ?></span>
                <input type="text" name="first_name" required data-parsley-maxlength="45" placeholder="Enter <?php echo $this->view_labels['first_name_label']; ?>">
                <span class="bt-flabels__error-desc">Required / Invalid <?php echo $this->view_labels['first_name_label']; ?></span>
            </div>
            <div class="right half bt-flabels__wrapper">
                <span class="sub_title"><i class="icon icon-icn-name"></i><?php echo $this->view_labels['last_name_label']; ?></span>
                <input type="text" name="last_name" required  data-parsley-maxlength="45" placeholder="Enter <?php echo $this->view_labels['last_name_label']; ?>">
                <span class="bt-flabels__error-desc">Required / Invalid <?php echo $this->view_labels['last_name_label']; ?></span>
            </div>
        </div>
        <div class="full">
            <div class="left half bt-flabels__wrapper">
                <span class="sub_title"><i class="icon icon-icn-phone-number"></i><?php echo $this->view_labels['phone_label']; ?></span>
                <input type="text" data-parsley-type="number" required name="phone" class="phone" data-parsley-maxlength="45" placeholder="Enter your <?php echo $this->view_labels['phone_label']; ?>">
                <span class="bt-flabels__error-desc">Required / Invalid <?php echo $this->view_labels['phone_label']; ?></span>
            </div>
            <div class="right half bt-flabels__wrapper">
                <span class="sub_title"><i class="icon icon-icn-email"></i><?php echo $this->view_labels['email_label']; ?></span>
                <input type="text" data-parsley-type="email" name="email" required data-parsley-maxlength="128" placeholder="Enter your <?php echo $this->view_labels['email_label']; ?>">
                <span class="bt-flabels__error-desc">Required / Invalid <?php echo $this->view_labels['email_label']; ?></span>
            </div>
        </div>
        <div class="full bt-flabels__wrapper">
            <span class="sub_title">
                <i class="icon icon-icn-description"></i><?php echo $this->view_labels['description']; ?>
            </span>
            <textarea tabindex="5" name="description" id="description" placeholder="Enter <?php echo $this->view_labels['description']; ?>"></textarea>
            <span class="bt-flabels__error-desc">Required / Invalid </span>
        </div>
    </div>
</div> <!-- your contact section end here -->
           