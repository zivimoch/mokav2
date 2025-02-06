<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Copy Text from Div</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .copy-area {
            padding: 10px;
            border: 1px solid #ccc;
            margin-bottom: 10px;
        }
        .copy-button {
            padding: 5px 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }
        .copy-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="copy-area" id="textDiv">
        This is the text that will be copied when you click the button. There are <span id="count_city">3</span> cities.
    </div>
    <button class="copy-button" onclick="copyText('textDiv')">Copy Text</button>

<script>
    $(document).ready(function(){
        // Generate a random number for the count_city span
        var randomNumber = Math.floor(Math.random() * 10) + 1;
        $('#count_city').text(randomNumber);
    });

    function copyText(textId) {
        var text = $('#' + textId).text();
        var tempInput = $('<input>');
        $('body').append(tempInput);
        tempInput.val(text).select();
        document.execCommand('copy');
        tempInput.remove();
        alert('Text copied to clipboard');
    }
</script>

</body>
</html>
