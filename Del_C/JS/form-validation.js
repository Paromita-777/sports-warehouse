$(document).ready(function () {

   // custom pattern method
      $.validator.addMethod( "pattern", function( value, element, param ) {
        if ( this.optional( element ) ) {
          return true;
        }
        if ( typeof param === "string" ) {
          param = new RegExp( "^(?:" + param + ")$" );
        }
        return param.test( value );
      }, "Invalid format." );

  // Validate checkout form
  $("#checkoutForm").validate({
    rules: {
      firstName: {
        required: true,
        maxlength: 50, 
        pattern: "[A-Za-z]+$"
      },
      lastName: {
        required: true,
        maxlength: 50,
        pattern: "[A-Za-z]+$"
      },
      street: {
        required: true,
        maxlength: 100,
        pattern: "^[A-Za-z0-9 .,'#/\\-]+$"
      },
      suburb: {
        required: true,
        maxlength: 50,
        pattern: "^[A-Za-z\\s\\-]+$"
      },
      state: {
        required: true
      },
      postcode: {
        required: true,
        pattern: "^\\d{4}$"
      },
      contactNumber: {
        required: true,
        maxlength: 20,
        pattern: "^[0-9\\s+()\\-]{8,20}$"
      },
      email: {
        required: true,
        email: true,
        maxlength: 255
      },
      nameOnCard: {
        required: true,
        maxlength: 50,
        pattern: "^[A-Za-z\\s\\-']+$"
      },
      creditCardNumber: {
        required: true,
        creditcard: true,
        maxlength: 19,
        pattern: "^(\\d{16}|\\d{4} \\d{4} \\d{4} \\d{4})$"
      },
      expiryDate: {
        required: true,
        pattern: "^(0[1-9]|1[0-2])/\\d{2}$",
        maxlength: 10
      },
      csv: {
        required: true,
        pattern: "^\\d{3}$"
      }
    },
  messages: {
    firstName: {
      required: "Please enter your first name.",
      maxlength: "First name must be no more than 50 characters.",
      pattern: "First name can only contain letters."
    },
    lastName: {
      required: "Please enter your last name.",
      maxlength: "Last name must be no more than 50 characters.",
      pattern: "Last name can only contain letters."
    },
    street: {
      required: "Please enter your street address.",
      maxlength: "Street address must be no more than 100 characters.",
      pattern: "Street address can only contain letters, numbers, spaces, and , . - / ' # characters."
    },
    suburb: {
      required: "Please enter your suburb.",
      maxlength: "Suburb name must be no more than 50 characters.",
      pattern: "Suburb can only contain letters, spaces, and hyphens."
    },
    state: {
      required: "Please select a state."
    },
    postcode: {
      required: "Please enter your postcode.",
      pattern: "Postcode must be exactly 4 digits."
    },
    contactNumber: {
      required: "Please enter your contact number.",
      maxlength: "Contact number must be no more than 20 characters.",
      pattern: "Contact number can include digits only."
    },
    email: {
      required: "Please enter your email address.",
      email: "Enter a valid email address.",
      maxlength: "Email must be no more than 255 characters."
    },
    nameOnCard: {
      required: "Please enter the name on the card.",
      maxlength: "Name on card must be no more than 50 characters.",
      pattern: "Name on card can only contain letters, spaces, apostrophes, and hyphens."
    },
    creditCardNumber: {
      required: "Please enter your card number.",
      creditcard: "Enter a valid credit card number.",
      maxlength: "Card number must be 16 digits or 19 characters if spaces are included.",
      pattern: "Card number must be 16 digits, optionally grouped as 4-digit blocks separated by spaces (e.g., 1234 5678 9012 3456)."
    },
    expiryDate: {
      required: "Please enter the expiry date.",
      pattern: "Use MM/YY format (e.g., 08/26).",
      maxlength: "Expiry date must be no more than 10 characters."
    },
    csv: {
      required: "Please enter the CVV.",
      pattern: "CSV must be exactly 3 digits."
    }
},

    errorElement: "span",
    errorClass: "error-message",
    submitHandler: function(form) {
        // Trim all input values before submit
        $.each($("#checkoutForm").serializeArray(), function(i, field) {
        $(`[name="${field.name}"]`).val($.trim(field.value));
      });
      // Combine address fields into one string
      const street = $("#street").val();
      const suburb = $("#suburb").val();
      const state = $("#state").val();
      const postcode = $("#postcode").val();

      // Format address how you want, e.g. "123 Smith St, Ryde, NSW 2112"
      const fullAddress = `${street}, ${suburb}, ${state} ${postcode}`;

      // Set the hidden input value
      $("#address").val(fullAddress);

      // Now submit the form
      form.submit();
    }
  });

});

