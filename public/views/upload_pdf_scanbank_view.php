<!-- Pop up modal that prompts user for more detailed search information. The format was
  taken from bootstrap, https://getbootstrap.com/docs/4.0/components/modal/ and the inputs
  for advanced search were implemented by me. -->
  <div class="modal fade" id="upload-pdf-modal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ScanBank Figure Extraction</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="../../src/figure_extraction/scanbank_figure_extraction_action.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <slot name="img">
                        <!-- Input box for the department. -->
                        Upload PDF: <input type="file" upload_max_filesize='100M' post_max_size='100M' id="fileToUpload" name="fileToUpload" required />
                    </slot>
                </div>

                <div class="modal-header">
                    <slot name="img">
                        <!-- Input box for the department. -->
                        <div class="g-recaptcha flex-center" style="margin: auto; width: 50%;" data-sitekey=<?php echo SITE_KEY ?>></div>
                    </slot>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" name="extract" class="btn btn-primary">Extract</button>
            </form>
        </div>
    </div>
</div>
</div>