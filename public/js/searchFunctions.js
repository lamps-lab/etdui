/**
 * Call the handle dissertation php action to either delete or save
 * the dissertation.
 * 
 * @param {int} entry Result number on SERP.
 */
 function handleDissertation(entry) {

    // Bind # with the element ID.
    var elementId = '#' + entry;

    var id = $(elementId).val();

    // Use AJAX to save dissertation data without redirecting the page.
    $.ajax({
        type: "POST",
        url: "../../src/elasticsearch/handle_dissertation.php",
        data: {
            dissertation_id: id
        },
        success: function (data) {
            // If save is successful, change button to green and the text to
            // saved.
            $(elementId).toggleClass('saved');
            $(elementId).toggleClass('save');
        }
    });
}

/**
 * Call the handle likes php action to either add a like or remove a like.
 * 
 * @param {int} entry Result number on SERP.
 */
function handleLike(entry) {
    var buttonElementId = '#' + entry + '-like';
    var id = $(buttonElementId).val();
    var displayLikesElementId = '#' + entry + '-likes';
    var likes = parseInt($(displayLikesElementId).text());

    // Use AJAX to save dissertation data without redirecting the page.
    $.ajax({
        type: "POST",
        url: "../../src/elasticsearch/handle_like.php",
        data: {
            figure_id: id
        },
        success: function (data) {

            console.log(data);

            if (data == 1) {
                // If the dissertation is liked, increment the number of
                // likes.
                likes = likes + 1;
            }
            if (data == 0) {
                // If the dissertation is unliked, decrement the number of
                // likes.
                likes = likes - 1;
            }

            $(buttonElementId).toggleClass('liked');
            $(buttonElementId).toggleClass('like');

            // Update the text displayed on the likes element.
            $(displayLikesElementId).text(likes + " Like(s)");
        }
    });
}

function handleSearchHistory() {
    var normalSearch = $('#search').val();
    var patentId = $('#patent-id').val();
    var textReference = $('#text-reference').val();
    var figureId = $('#figure-id').val();
    var description = $('#description').val();
    var aspect = $('#aspect').val();
    var object = $('#object').val();
    var searchURL = $('#url').text();

    $.ajax({
        type: "POST",
        url: "../../src/elasticsearch/handle_history.php",
        data: {
            handled: "handled",
            normal_search: normalSearch,
            patent_id: patentId,
            text_reference: textReference,
            figure_id: figureId,
            description: description,
            aspect: aspect,
            object: object,
            url: searchURL
        },
        success: function (data) {
            console.log(data);
            $('#save_history').toggleClass('saved-history');
            $('#save_history').toggleClass('save-history');
        }
    });
}

function deleteCheckedHistory() {

    $('.delete:checkbox:checked').each(function () {
        var checkboxId = '#' + $(this).attr('id');
        var divId = $(this).attr('id') + '-history';

        $.ajax({
            type: "POST",
            url: "../../src/elasticsearch/handle_history.php",
            data: {
                handled: "handled",
                url: $(this).val()
            },
            success: function (data) {
                $(checkboxId).hide();
                $('div').find(`[data-value='${divId}']`).hide();
            }
        });
    });
}

function deleteList() {
    $('.delete:checkbox:checked').each(function () {
        var checkboxId = '#' + $(this).attr('id');
        var formId = '#' + $(this).attr('id') + '-list';

        $.ajax({
            type: "POST",
            url: "../../src/elasticsearch/handle_list.php",
            data: {
                delete: "delete",
                id: $(this).val()
            },
            success: function (data) {
                $(checkboxId).hide();
                $(formId).hide();
            }
        });
    });
}

/**
 * Convert the speech from the microphone to text and set it
 * inside of the search bar.
 * 
 * @param {string} micId element id for microphone button.
 * @param {string} inputId element id for the input.
 */
function speechToText(micId, inputId) {

    var microphoneId = '#' + micId;

    var searchBar = document.getElementById(inputId);

    // Initialize a speech recognition object.
    var SpeechRecognition = SpeechRecognition || webkitSpeechRecognition;
    var speechRecognition = new SpeechRecognition();

    speechRecognition.onstart = function () {
        // When microphone is on, change the background to green.
        $(microphoneId).css('background', '#73EC21');
    }

    speechRecognition.onspeechend = function () {
        // If speech stops, stop the speech recognition and return
        // the button to its original color.
        speechRecognition.stop();
        $(microphoneId).css('background', '#00BFFF');
    }

    speechRecognition.onresult = function (event) {
        // Set the value in the search box.
        var transcript = event.results[0][0].transcript;
        searchBar.value = transcript;
    }

    // Start the speech recognition.
    speechRecognition.start();
}

function suggestResults(elementId) {

    var input = document.getElementById(elementId).value;

    $.ajax({
        type: "POST",
        url: "../../src/elasticsearch/suggest_action.php",
        data: {
            text: input
        },
        success: function (data) {

            $('#' + elementId).autocomplete({
                source: JSON.parse(data)
            });
        }
    });
}

function addTag(figureId) {

    var tag = "";

    if ($('#tag').val()) {
        tag = $('#tag').val();
    } else {
        tag = $('#tag-' + figureId).val();
    }

    if (tag) {
        $.ajax({
            type: "POST",
            url: "../../src/elasticsearch/handle_tag.php",
            data: {
                handle: "added",
                tag: tag,
                figure_id: figureId
            },
            success: function (data) {

                if (data == 1) {
                    $('#tag-error').text("The tag is already used.");
                    $('#tag-error').attr('hidden', false);
                } else {
                    location.reload();
                }
            }
        });
    } else {
        $('#tag-error').text("The tag can't be empty.");
        $('#tag-error').attr('hidden', false);
    }
}

function removeTag(tagId) {
    $.ajax({
        type: "POST",
        url: "../../src/elasticsearch/handle_tag.php",
        data: {
            handle: "removed",
            tag_id: tagId
        },
        success: function (data) {
            $('#' + tagId).remove();
            $('#remove-' + tagId).remove();
        }
    });
}

function handleListItem(listId, userId, figureId) {
    $.ajax({
        type: "POST",
        url: "../../src/elasticsearch/handle_list_item.php",
        data: {
            handle: "handled",
            list_id: listId,
            user_id: userId,
            figure_id: figureId
        },
        success: function (data) {

        }
    });
}

var counter = 0;

function appendAddListElement(figureId) {
    $('#add-to-list-modal-' + figureId).append("<div class='modal-header' id='add-list-" + counter + "'><slot>" +
        "List Name: <input type='text' id='name-" + counter + "' />" +
        "<button type='button' onClick='addList(" + counter + "," + figureId + ")' class='btn btn-primary'>Add List</button>" +
        "</slot>");

    counter++;
}

function addList(listEntryNum, figureId) {
    listName = $('#name-' + listEntryNum).val();

    $.ajax({
        type: "POST",
        url: "../../src/elasticsearch/handle_list.php",
        data: {
            name2: listName,
        },
        success: function (data) {
            listObject = JSON.parse(data);

            var newListElement = "<div class='modal-header'><slot>" + listName +
                "<input type='checkbox' onclick='handleListItem(\"" + listObject.listId + "\", \"" + listObject.userId + "\", \"" + figureId + "\")'></slot></div>";

            $('#add-list-' + listEntryNum).remove();
            $('.modal-body').append(newListElement);

        }
    });
}

function checkSegmentedCorrectly() {
    if ($("#yes-segmented-correctly").is(":checked")) {
        // If "yes" radio button is selected, empty the div for entering
        // correct labels.
        $(".segmented-correctly").empty();
    } else {
        if (!$("#num-segmented").length) {
            var enterNumSegments = "<b>How many subfigures are in the original figure?" +
                "<input type='text' id='num-segmented' name='num-segmented'/>";

            $(".segmented-correctly").append(enterNumSegments);
        }
    }
}

function checkLabeledCorrectly(id) {

    var enterLabels = "";
    var size = 0;

    if ($("#yes-" + id).is(":checked")) {
        // If "yes" radio button is selected, empty the div for entering
        // correct labels.
        $(".enter-correct-labels-" + id).empty();
    }
    
    else {
        if (!$("#" + id).length) {
            size = $('#num-segmented').val();

            if (id == "label-subfigures") {
                var enterLabels = "<b> Type the correct labels of subfigures, from low to high </b><br>";

                for (let i = 0; i < size; i++) {
                    enterLabels = enterLabels + "<input type='text' id='" + id + "-" + i + "' /><br>";
                }

                $(".enter-correct-labels-" + id).append(enterLabels);

                var allEnterLabels = "<input type='hidden' id='" + id + "' name='" + id + "' />";
                $(".enter-correct-labels-" + id).append(allEnterLabels);
            }

            if (id == "label-objects") {
                var enterLabels = "<b> Type the correct object for each subfigure. </b><br>";

                enterLabels = enterLabels + "<input type='text' id='" + id + "' name='" + id + "' />";
                $(".enter-correct-labels-" + id).append(enterLabels);
            }

            if (id == "label-aspects") {
                var enterLabels = "<b> Type the correct aspect for each subfigure. </b><br>";

                for (let i = 0; i < size; i++) {
                    enterLabels = enterLabels + "<input type='text' id='" + id + "-" + i + "' /><br>";
                }

                $(".enter-correct-labels-" + id).append(enterLabels);

                var allEnterLabels = "<input type='hidden' id='" + id + "' name='" + id + "' />";
                $(".enter-correct-labels-" + id).append(allEnterLabels);
            }
        }
    }
}

function combineLabels() {

    var numSegmented = $('#num-segmented').val();
    var subfigureLabels = "";
    var aspectLabels = "";

    for (let i = 0; i < numSegmented; i++) {
        subfigureLabels += $('#label-subfigures-' + i).val() + ";";
        aspectLabels += $('#label-aspects-' + i).val() + ";";
    }

    $('#label-subfigures').val(subfigureLabels);
    $('#label-aspects').val(aspectLabels);
}

function backToResults(previousURL) {
    window.location.replace("https://" + previousURL);
}