@extends('layout.app')

@section('title','DIY Detail')

@section('stylesheet')
@parent
    <link rel="stylesheet" href="{{ asset('css/eyescare.css') }}">
@endsection

@section('content')
{{-- BEGIN:: DIY Detail Wrapper --}}
<div class="diy-detail-wrapper">
    <input id="diyId" type="hidden" name="diyId" value="{{$id}}">
    <h4>Our DIY #{{$id}}</h4>
    <div class="diy-detail-image-wrapper">
        <img id="diy-detail-image" src="" alt="diy detail image">
    </div>
    <div class="diy-detail-description-wrapper">
        <div class="diy-detail-description-header">
            <h4>Title</h4>
            <p>By Stephany</p>
        </div>
        <div class="diy-detail-description-body">
            <p id="diy-detail-description"></p>
        </div>
        <div class="diy-detail-description-date">
            <p>10/22/2020</p>
        </div>
    </div>
</div>
{{-- END:: DIY Detail Wrapper --}}
@endsection

@section('script')
<script>
    // client width
    clientWidth = $(window).width();

    // track user width and process replacing paragraph and image
    $(window).bind('resize', function(e){
        replaceDemoParagraph(clientWidth);
        replaceDemoDiyImage();
    });
    // replace paragraph in every specific openning width
    $(document).ready(function(){
        replaceDemoParagraph(clientWidth);
        replaceDemoDiyImage();
    });

    // replace demo paragraph and demo diy image of diy description based on user width
    function replaceDemoParagraph(clientWidth){
        mobileDescription  = "Welcome to the website. If you’re here, you’re likely<br>looking to find random words. Random Word Generator<br>is the perfect tool to<br>help you do this. While this tool isn’t a word creator, it<br>is a word generator that will generate random words<br>for a variety of<br>activities or uses. Even better, it allows you to adjust<br>the parameters of the random words to best fit your<br>needs<br><br>. The first option the tool allows you to adjust is the<br>number of random words to be generated. You can<br>choose as many or as few<br>as you’d like. You also have the option of choosing<br>words that only begin with a certain letter, only end<br>with a certain letter or<br>only begin and end with certain letters. If you leave<br>these blank, the randomize words that appear will be<br>from the complete list.<br><br>You also have the option of choosing the number of<br>syllables of the words or the word length of the<br>randomized words. There are<br>also options to further refine by choosing “less than”<br>or “greater than” options for both syllables and word<br>length. Again, if you<br>leave the space blank, the complete list of randomized<br>words will be used. Finally, you can choose between<br>standard text or<br>cursive words. The cursive words will all be in cursive<br>using cursive letters.<br><br>Once you have input all of your specifications, all you<br>have to do is to press the Generate Random Words<br>button, and a list of<br>random words will appear. Below are some of the<br>common ways people use this tool";
        desktopDescription = "Welcome to the website. If you’re here, you’re likely looking to find random words. Random Word Generator is the perfect tool to<br>help you do this. While this tool isn’t a word creator, it is a word generator that will generate random words for a variety of<br>activities or uses. Even better, it allows you to adjust the parameters of the random words to best fit your needs.<br><br>The first option the tool allows you to adjust is the number of random words to be generated. You can choose as many or as few<br>as you’d like. You also have the option of choosing words that only begin with a certain letter, only end with a certain letter or<br>only begin and end with certain letters. If you leave these blank, the randomize words that appear will be from the complete list.<br><br>You also have the option of choosing the number of syllables of the words or the word length of the randomized words. There are<br>also options to further refine by choosing “less than” or “greater than” options for both syllables and word length. Again, if you<br>leave the space blank, the complete list of randomized words will be used. Finally, you can choose between standard text or <br>cursive words. The cursive words will all be in cursive using cursive letters.<br><br>Once you have input all of your specifications, all you have to do is to press the Generate Random Words button, and a list of<br>random words will appear. Below are some of the common ways people use this tool<br>"; 
        
        if(clientWidth > 991) {
            $('#diy-detail-description').html(desktopDescription);
        } else {
            $('#diy-detail-description').html(mobileDescription);
        }
    }

    // replace demo diy image based on diy Id
    function replaceDemoDiyImage(){
        diyId = $('#diyId').val();

        imagePaths = {
            1 : "{{asset('img/eyescare/diy1.png')}}",
            2 : "{{asset('img/eyescare/diy2.png')}}",
            3 : "{{asset('img/eyescare/diy3.png')}}",
        }
        switch (diyId) {
            case "1":
                $('#diy-detail-image').attr("src", imagePaths[diyId]);
                break;
            case "2":
                $('#diy-detail-image').attr("src", imagePaths[diyId]);
                break;
            case "3":
                $('#diy-detail-image').attr("src", imagePaths[diyId]);
                break;
            default:
                break;
        }
    }
</script>
@endsection