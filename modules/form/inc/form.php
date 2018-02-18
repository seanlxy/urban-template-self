<?php

if( !empty($form_fields) )
{
//    die(var_dump($form_fields));
    $form_fields_view = '';

    foreach ($form_fields as $form_field)
    {
        $form_field_label         = $form_field['label'];
        $form_field_type         = $form_field['type'];
        $form_field_value         = $form_field['value'];
        $form_field_is_required         = $form_field['required'];
        $form_field_description         = $form_field['description'];
        $form_field_class         = $form_field['className'];
        $form_field_name          = $form_field['name'];
        $form_field_subtype   = $form_field['subtype'];
        $form_field_values = $form_field['values'];
        $form_field_is_toggle = $form_field['toggle'];
        $form_field_is_multiple = $form_field['multiple'];
        $form_field_type          = $form_field['type'];
        $form_field_placeholder          = $form_field['placeholder'];

        $is_text     = ($form_field_type == 'text');
        $is_email    = ($form_field_type == 'email');
        $is_select   = ($form_field_type == 'select');
        $is_textarea = ($form_field_type == 'textarea');
        $is_radio    = ($form_field_type == 'radio-group');
        $is_checkbox = ($form_field_type == 'checkbox-group');
        $is_header   = ($form_field_type == 'header');
        $is_date     = ($form_field_type == 'date');

        $form_field_placeholder_attr = ($form_field_placeholder) ? ' placeholder="'.$form_field_placeholder.'"' : '';
        $form_field_is_required_elm  = ($form_field_is_required == true) ? '<span class="text-danger"><small><em>&#42;</em></small></span>' : '';

        $form_field_options_view = '';

        $field_error = ( $form_field_is_required == true && $_POST ) ? $form_validation->getError($form_field_name) : '';

        if( $is_header )
        {
            $form_fields_view .= ' <div class="form-group">
                <'. $form_field_subtype.' class="'.$form_field_class.'">'.$form_field_label.'</'. $form_field_subtype.'>
            </div>';

        }else if( $is_text || $is_email ||  $is_date)
        {

            $field_value      = ($_POST) ? sanitize_input($form_field_name) : $form_field_value;
            
            $form_field_class .= ( $is_date ) ? ' date-control' : '';
            $form_field_type   = ( $is_date ) ? ' text' : $form_field_type;

            $form_field_type   = ( $is_text ) ? $form_field_subtype : $form_field_type;
        
            $form_fields_view .= <<<TEXTEMAILDATE
                <div class="form-group">
                    <label for="$form_field_name" class="control-label">$form_field_label $form_field_is_required_elm</label>
                    <input type="$form_field_type" id="$form_field_name" value="$field_value" 
                        class="$form_field_class" name="$form_field_name" 
                        $form_field_placeholder_attr  
                    >
                    $field_error
                </div>
TEXTEMAILDATE;
;
        }
        elseif( $is_select && !empty($form_field_values) )
        {
            foreach ($form_field_values as $form_field_single_value)
            {
                $form_field_option_value = $form_field_single_value['value'];
                $form_field_option_label = $form_field_single_value['label'];
                $form_field_option_selected = $form_field_single_value['selected'];
                $is_selected             = ($form_field_option_selected == true) ? ' selected="selected"' : '';

                $form_field_options_view .= '<option value="'.$form_field_option_value.'"'.$is_selected.'>'.$form_field_option_label.'</option>';
            }

            $is_multipled      = (($form_field_is_multiple == true)) ? ' multiple="multiple"' : '';

            $form_fields_view .= <<< SELECT
                <div class="form-group">
                    <label for="$form_field_name" class="control-label">$form_field_label $form_field_is_required_elm</label>
                    <select id="$form_field_name" class="$form_field_class" name="$form_field_name"  $is_multipled >
                        <option value="">-- select --</option>
                        $form_field_options_view
                    </select>
                    $field_error
                </div>
SELECT;
        }
        elseif( $is_textarea )
        {
            $field_value = ($_POST) ? sanitize_input($form_field_name) : $form_field_value;
            
            $form_fields_view .= <<< TEXTAREA
                <div class="form-group">
                    <label for="$form_field_name" class="control-label">$form_field_label $form_field_is_required_elm</label>
                    <textarea id="$form_field_name" class="$form_field_class" name="$form_field_name" $form_field_placeholder_attr >$field_value</textarea>
                    $field_error
                </div>
TEXTAREA;
        }
        elseif( ($is_checkbox || $is_radio) )
        {
            $form_fields_view .= ' <div class="form-group">';

            $selection_type = ($form_field_type === 'checkbox-group') ? 'checkbox' : 'radio';

            if( $form_field_type === 'checkbox-group' || $form_field_type === 'radio-group' )
            {
                $form_fields_view .= '<label class="control-label">'.$form_field_label.' '.$form_field_is_required_elm.'</label><div class="control-group">';

                $elmWrapperCls = ($is_checkbox && $form_field_is_toggle == true) ? ' switch' : '';
                $elmSwitch     = ($is_checkbox && $form_field_is_toggle == true) ? '<span class="toggle__switch round"></span>' : '';
                $elmLabelCls  = ($is_checkbox && $form_field_is_toggle == true) ? 'toggle__switch__label' : '';

                foreach ($form_field_values as $form_field_single_value)
                {
                    $form_field_option_value = $form_field_single_value['value'];
                    $form_field_option_label = $form_field_single_value['label'];
                    $form_field_option_selected = $form_field_single_value['selected'];
                    $is_selected             = ($form_field_option_selected == true) ? ' checked="checked"' : '';

                    $form_fields_view .= <<< CHECKBOXRADIOGROUP
                        <label class="$selection_type-inline$elmWrapperCls">
                            <input type="$selection_type" id="$form_field_name" name="{$form_field_name}[]" value="$form_field_option_value"  $is_selected> 
                            $elmSwitch
                            <span class="$elmLabelCls"> $form_field_option_label</span>
                        </label>
CHECKBOXRADIOGROUP;

                }

                $form_fields_view .= "$field_error</div>";
                // '. ((empty($elmSwitch)) ? $form_field_option_label.$form_field_is_required_elm : '').'
            }
            else
            {
                $form_fields_view .= <<< HTMLBLOCK
                    <label class="$form_field_type-inline">
                        <input type="$form_field_type" id="$form_field_name" name="$form_field_name" value="$form_field_value" > $form_field_label $form_field_is_required_elm
                    </label> $field_error
HTMLBLOCK;
            }

            $form_fields_view .= '</div>';
        }
    }

    if( $has_terms_and_conditions )
    {

        $terms_link = '<label class="checkbox-inline">
            <input type="checkbox" name="tc" id="tc" value="1" '.$tc_checked.'> 
            <a href="#tc-modal" class="trigger-tc-modal"><u>Click here to read and accept the terms and conditions</u></a>
        </label>';
    }
    else
    {
        $terms_link = '';
    }

    $form = <<< H

    <div class="row comp-form">
        <form action="{$action}" method="post" role="form" class="custom-form">
            <div class="col-xs-12 col-sm-6 col-sm-offset-3" style="margin-top:50px;margin-bottom:50px;">
                {$form_fields_view}
                <div class="form-group">
                    {$terms_link}
                    {$tc_error_msg}
                </div>
               
                <div class="form-group {$captcha_error_class}">
                <label></label>
                <div class="controls">
                    <div class="g-recaptcha" data-sitekey="{$gcSiteKey}"></div>
                    <span class="text-danger">{$captcha_error_msg}</span>
                </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn{$form_submit_btn_cls} booking-btn" id="form-submit-btn" name="continue" value="continue"{$form_submit_btn_attr}>Submit</button>
                </div>

            </div>
        </form>
    </div>
<script src="https://www.google.com/recaptcha/api.js"></script>
H;


if( $has_terms_and_conditions )
{
    $tags_arr['body_view'] .= <<< H

    <div class="modal fade" id="tc-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Terms & Conditions</h4>
                </div>
                <div class="modal-body">
                    {$terms_and_conditions}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary accept-tc" data-dismiss="modal">I ACCEPT</button>
                  </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
H;

}

}

?>