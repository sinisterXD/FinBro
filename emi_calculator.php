<?php ob_start() ?>
<html>
<head>
    
    <title>EMI Calculator</title>
    <link rel="stylesheet" type="text/css" href="css/emi_calculator.css"/>
    <?php include'header.php'?>
</head>
<body>
    <div class="container_emi_container_parent">
    <h2>EMI Calculator</h2>
    <div class="container_emi_container_parent_child">
    <form method="post">
        <label for="amount">Loan Amount ($):</label>
        <input type="number" id="amount" name="amount" required><br><br>
        
        <label for="rate">Annual Interest Rate (%):</label>
        <input type="number" id="rate" name="rate" step="0.01" required><br><br>
        
        <label for="term">Loan Term (in years):</label>
        <input type="number" id="term" name="term" required><br><br>
        
        <input type="submit" value="Calculate EMI">
    </form>
</div>
</div>

    <?php
    function calculateEMI($principal, $rate, $term) {
        // Convert annual interest rate to monthly rate
        $monthly_rate = $rate / (12 * 100);
        
        // Calculate EMI using the formula
        $emi = $principal * $monthly_rate * pow(1 + $monthly_rate, $term * 12) / (pow(1 + $monthly_rate, $term * 12) - 1);
        
        return $emi;
    }

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get user inputs
        $loan_amount = $_POST["amount"]; // Loan amount in dollars
        $annual_interest_rate = $_POST["rate"]; // Annual interest rate (in percentage)
        $loan_term_in_years = $_POST["term"]; // Loan term in years

        // Calculate EMI
        $emi = calculateEMI($loan_amount, $annual_interest_rate, $loan_term_in_years); 

        echo '<div class="container_emi_container_parent_child">';
        echo "<h3>Loan Details:</h3>";
        echo 'Loan amount: <span class="loan-details">$' . $loan_amount . '</span><br>';
        echo 'Annual interest rate: <span class="loan-details">' . $annual_interest_rate . '%</span><br>';
        echo 'Loan term: <span class="loan-details">' . $loan_term_in_years . ' years</span><br>';
        echo '<h3>EMI: <span class="loan-details">$' . round($emi, 0) . '</span></h3>';
        echo 'Interest Payable: <span class="loan-details">$' . round(($emi*($loan_term_in_years*12))-$loan_amount,2) . '</span><br>';
        echo '<h2>Total Payment: <span class="loan-details">$' . round($emi*($loan_term_in_years*12),2) . '</span></h2>';
        echo '</div>';
    }
    ?>
    <?php include 'footer.php';?>
</body>
</html>
