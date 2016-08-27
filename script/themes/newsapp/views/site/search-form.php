<div class="row main-index">
	<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
		<div class="thumbnails">
			<div class="entry search-main">
        	<form action="<?php echo Yii::app()->request->baseUrl; ?>/search" class="form-horizontal" role="form" type="get">
            <div class="form-group">
              <div class="col-xs-10 col-sm-6 col-md-6 col-lg-6 col-xs-offset-1 col-sm-offset-3 col-md-offset-3 col-lg-offset-3">
                <input name="s" type="text" class="form-control" id="search-val" placeholder="Search site">
              </div>
            </div>
            <div class="form-group">
                <div class="col-xs-4 col-sm-2 col-md-2 col-lg-2 col-xs-offset-7 col-sm-offset-7 col-md-offset-7 col-lg-offset-7">
                  <button type="submit" class="btn btn-default btn-block btn-search">search</button>
                </div>
              </div>
            </form>
        </div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
		<?php $this->renderPartial('/layouts/listsidebar'); ?>
	</div>
</div>
<?php
    $this->pageTitle = 'Search';
    $this->pageDesc = 'Search website';
    $this->pageOgTitle = $this->pageTitle;
    $this->pageOgDesc = $this->pageDesc;
    $this->pageRobotsIndex = 'false';
	 $this->pageCanonial = Yii::app()->params->site_url.'/search-form/';
	
?>