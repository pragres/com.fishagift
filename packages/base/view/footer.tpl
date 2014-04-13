<?php 
	$lang = framework::session_get('language');
	include_once framework::resolve("packages/base/i18n/$lang/footer.php"); 
?>

		<!--section: footer-->
		<div id="ending-gradient" class="container"></div>
		<div id="waves"></div>
		<div id="section-footer">
			<div class="container">
				<div class="col-lg-8 col-md-8 col-sm-12">
					<div class="row">
						<div class="col-lg-3 col-md-3 col-sm-3">
							<strong><?php echo $i18n['help']; ?></strong>
							<ul>
								<!--<li><a href="<?php echo framework::link_to('store/about'); ?>#faq"><abbr title="Frequently Asked Questions">FAQ</abbr></a></li>-->
								<li><a href="#"><?php echo $i18n['support']; ?></a></li>
								<li><a href="<?php echo framework::link_to('store/about'); ?>"><?php echo $i18n['about']; ?></a></li>
							</ul>
		
							<strong><?php echo $i18n['navigation']; ?></strong>
							<ul>
								<li><a href="#"><?php echo $i18n['sitemap']; ?></a></li>
								<li><a href="<?php echo framework::link_to('admin/dashboard'); ?>"><?php echo $i18n['admin']; ?></a></li>
							</ul>
						</div>

						<div class="col-lg-4 col-md-4 col-sm-4">
							<strong><?php echo $i18n['legal']; ?></strong>
							<p class="text-left"><?php echo $i18n['legalnotes']; ?></p>
							<!--<a href="#" class="btn btn-default"><?php echo $i18n['readmore']; ?></a>-->
						</div>

						<div class="col-lg-4 col-md-4 col-sm-4 col-lg-offset-1 col-md-offset-1 col-sm-offset-1">
							<address>
								<strong>Pragres Corp.</strong><br>
								3250 NW 13th Terr<br/>
								Miami, Fl 33125<br/>
								<a href="http://pragres.com" target="_blank">http://pragres.com</a>
							</address>

							<address>
								<strong><?php echo $i18n['contactus']; ?></strong><br>
								<?php //<abbr title="Phone">P:</abbr> (510) 457-1656<br/> ?>
								<a href="mailto:support@fishagift.com">support@fishagift.com</a>
							</address>
						</div>
					</div>

					<div class="row" style="padding-top: 50px;">
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div id="footer-trustus" class="trust-icon">
								<?php echo $i18n['trustus']; ?>
							</div>

							<!-- begin GoDaddy ssl certificate -->
							<span id="siteseal" style="vertical-align: 30px; margin-right: 5px;">
								<script type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=QzFXWlAD40hjotcw0oZ8FZwtAWpTu95I2LZGQbOytcVn82jLMeWtR61RHm"></script>
							</span>
							<!-- begin GoDaddy ssl certificate -->

							<!-- Begin Official PayPal Seal -->
							<div class="trust-icon" style="vertical-align: top;">
								<a href="https://www.paypal.com/us/verified/pal=salvi.pascual@pragres.com" target="_blank"><img src="<?php echo framework::resolve('static/graphs/verification_seal.png'); ?>" border="0" alt="Official PayPal Seal"/></a>
							</div>
							<!-- End Official PayPal Seal -->

							<!-- Begin GoDaddy certification Seal -->
							<div class="trust-icon">
								<span id="cdSiteSeal3"><script type="text/javascript" src="//tracedseals.starfieldtech.com/siteseal/get?scriptId=cdSiteSeal3&amp;cdSealType=Seal3&amp;sealId=55e4ye7y7mb7300b9e1e3f3cae69a80fany7mb7355e4ye75c2db89d53be85f35"></script></span>
							</div>
							<!-- End GoDaddy certification Seal -->
						</div>
					</div>
				</div>

				<div id="footer-finishg" class="col-lg-4 col-md-4 hidden-sm hidden-xs text-center">
					<div id="like-us" class="text-left">
						<div style="margin-bottom: 5px;"><?php echo $i18n['facebook']; ?></div>
						<div class="fb-like" data-href="https://fishagift.com" data-width="450" data-layout="button_count" data-show-faces="false" data-send="false"></div>				
					</div>
				</div>

			</div>
		</div>

		<!-- BEGIN mouseflow code -->
		<script type="text/javascript">
		var _mfq = _mfq || [];
		(function() {
		var mf = document.createElement("script"); mf.type = "text/javascript"; mf.async = true;
		mf.src = "//cdn.mouseflow.com/projects/41172ffa-0f90-47e5-8017-1f9add421267.js";
		document.getElementsByTagName("head")[0].appendChild(mf);
		})();
		</script>
		<!-- END mouseflow code -->
	</body>
</html>