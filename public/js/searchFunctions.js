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
        success: function(data) {
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
            dissertation_id: id
        },
        success: function(data) {

            console.log(data);

            if (data == 1) {
                // If the dissertation is liked, increment the number of
                // likes.
                likes = likes + 1;
            } else {
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

/**
 * Calls handle search history PHP script.
 */
function handleSearchHistory() {
    var normalSearch = $('#search').val();
    var title = $('#title').val();
    var author = $('#author').val();
    var abstract = $('#abstract').val();
    var publisher = $('#publisher').val();
    var subject = $('#subject').val();
    var department = $('#department').val();
    var degree = $('#dgree').val();
    var startDate = $('#start_date').val();
    var endDate = $('#end_date').val();
    var searchURL = $('#url').text();

    $.ajax({
        type: "POST",
        url: "../../src/elasticsearch/handle_history.php",
        data: {
            handled: "handled",
            normal_search: normalSearch,
            title: title,
            author: author,
            abstract: abstract,
            publisher: publisher,
            subject: subject,
            department: department,
            degree: degree,
            beg_date: startDate,
            end_date: endDate,
            url: searchURL
        },
        success: function(data) {
            console.log(data);
            // If search history is successfully saved or unsaved,
            // toggle the save search history button.
            $('#save_history').toggleClass('saved-history');
            $('#save_history').toggleClass('save-history');
        }
    });
}

/**
 * Delete the checked search history.
 */
function deleteCheckedHistory() {
    var searchIds = [];

    $('.delete:checkbox:checked').each(function() {
        var checkboxId = '#' + $(this).attr('id');
        var divId = $(this).attr('id') + '-history';

        $.ajax({
            type: "POST",
            url: "../../src/elasticsearch/handle_history.php",
            data: {
                handled: "handled",
                url: $(this).val()
            },
            success: function(data) {
                $(checkboxId).hide();
                $('div').find(`[data-value='${divId}']`).hide();
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

    speechRecognition.onstart = function() {
        // When microphone is on, change the background to green.
        $(microphoneId).css('background', '#73EC21');
    }

    speechRecognition.onspeechend = function() {
        // If speech stops, stop the speech recognition and return
        // the button to its original color.
        speechRecognition.stop();
        $(microphoneId).css('background', '#00BFFF');
    }

    speechRecognition.onresult = function(event) {
        // Set the value in the search box.
        var transcript = event.results[0][0].transcript;
        searchBar.value = transcript;
    }

    // Start the speech recognition.
    speechRecognition.start();
}

/**
 * Return suggested search results from the PHP script, and parse it
 * into a JSON array that will be used for the autocomplete feature.
 * @param {*} elementId 
 */
function suggestResults(elementId) {

    var input = document.getElementById(elementId).value;

    $.ajax({
        type: "POST",
        url: "../../src/elasticsearch/suggest_action.php",
        data: {
            text: input
        },
        success: function(data) {

            $('#' + elementId).autocomplete({
                source: JSON.parse(data)
            });
        }
    });
}

/**
 * Call the add tag functionality in PHP.
 * @param {*} figureId 
 */
function addTag(figureId) {

    var tag = $('#tag').val();

    if (tag) {
        $.ajax({
            type: "POST",
            url: "../../src/elasticsearch/handle_tag.php",
            data: {
                handle: "added",
                tag: tag,
                figure_id: figureId
            },
            success: function(data) {

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

/**
 * Calls remove tag functionality in the PHP script.
 * @param {*} tagId 
 */
function removeTag(tagId) {
    $.ajax({
        type: "POST",
        url: "../../src/elasticsearch/handle_tag.php",
        data: {
            handle: "removed",
            tag_id: tagId
        },
        success: function(data) {
            $('#' + tagId).remove();
            $('#remove-' + tagId).remove();
        }
    });
}

/**
 * Toggle the show more button and show more if show more has been clicked.
 * Set to preview mode if show less has been clicked.
 * @param {*} entry 
 */
function showMore(entry) {
    $('#show-more-' + entry).toggle();
    $('#preview-' + entry).toggle();

    if ($('#show-more-button-' + entry).text() === "Show More") {
        $('#show-more-button-' + entry).text("Show Less");
        $('#dots-' + entry).hide();
    } else {
        $('#show-more-button-' + entry).text("Show More");
        $('#dots-' + entry).show();
    }
}

/**
 * Call the handle list item PHP script.
 * @param {*} listId 
 * @param {*} userId 
 * @param {*} dissertationId 
 */
function handleListItem(listId, userId, dissertationId) {
    $.ajax({
        type: "POST",
        url: "../../src/elasticsearch/handle_list_item.php",
        data: {
            handle: "handled",
            list_id: listId,
            user_id: userId,
            dissertation_id: dissertationId
        },
        success: function(data) {

        }
    });
}

/**
 * Call the delete list PHP script.
 */
function deleteList() {
    $('.delete:checkbox:checked').each(function() {
        var checkboxId = '#' + $(this).attr('id');
        var formId = '#' + $(this).attr('id') + '-list';

        $.ajax({
            type: "POST",
            url: "../../src/elasticsearch/handle_list.php",
            data: {
                delete: "delete",
                id: $(this).val()
            },
            success: function(data) {
                $(checkboxId).hide();
                $(formId).hide();
            }
        });
    });
}