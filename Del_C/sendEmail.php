// Encode values safely for output in HTML (email content and confirmation page)
      $firstName = esc($firstName);
      $lastName = esc($lastName);
      $contactNumber = esc($contactNumber);
      $email = esc($email);
      $question = esc($question);
      

      // Build email
      $toEmail = "paromita.sarkar.srk@gmail.com";
      $subject = "Sports Warehouse Contact Form";
      $htmlBody = <<<HTML
      <h1>Sports Warehouse Website contact form submission</h1>
      <p>The Sports Warehouse Website contact form has been filled in.</p>
      <ul>
        <li>First Name: $firstName</li>
        <li>Last Name: $lastName</li>
        <li>Contact Number: $contactNumber</li>
        <li>Email: $email</li>
        <li>Any Questions?: $question</li>
      </ul>
      HTML;
      $altBody = <<<TEXT
      Sports Warehouse Website contact form submission

      The Sports Warehouse Website contact form has been filled in.

      - First Name: $firstName
      - Last Name: $lastName
      - Contact Number: $contactNumber
      - Email: $email
      - Any Questions?: $question
      TEXT;

      // Send email
      // $emailSentSuccessfully = sendEmail($toEmail, $subject, $htmlBody, $altBody);
