<!-- modal windows to show images -->
<div class="modal fade" id="thumbnailViewer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header text-center" style="padding: 8px;">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" title="<?php echo $i18n['close']; ?>">&times;</button>
				<h4 id="thumbnailViewer-title" class="modal-title" style="font-size: small; margin: 0px; font-weight: bold;"></h4>
			</div>
			<div class="modal-body text-center" style="padding: 3px;">
				<span id="image-configs" class="hidden" section-parent="" access-key=""></span>
				<img id="thumbnailViewer-image" class="rotate-image-1" style="width:570px;" src="" alt=""/>

				<div class="modal-body-tools pull-left">
					<button class="modal-body-btn btn btn-success btn-mini pull-left" onclick="popUpPrevious();"><span class="glyphicon glyphicon-arrow-left"></span> <?php echo $i18n['previous']; ?></button>
					<button id="modal-body-btn-select" class="modal-body-btn btn btn-danger btn-mini" onclick="addToCartThumbnailViewerModal();"><span class="glyphicon glyphicon-shopping-cart"></span> <?php echo $i18n['select']; ?></button>
					<button class="modal-body-btn btn btn-success btn-mini pull-right" onclick="popUpNext();"><?php echo $i18n['next']; ?> <span class="glyphicon glyphicon-arrow-right"></span></button>
				</div>
 			</div>
		</div>
	</div>
</div>