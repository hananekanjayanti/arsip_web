      <?php 
      if ($this->session->flashdata('error')!==null) {
        ?>
        <div class="alert alert-danger">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <?php echo $this->session->flashdata('error') ?>
        </div>
        <?php
      }

      if ($this->session->flashdata('success')!==null) {
        ?>
        <div class="alert alert-success">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <?php echo $this->session->flashdata('success') ?>
        </div>
        <?php
      }
      ?>
          <link href="<?php echo base_url('assets/calendar/dist/') ?>fullcalendar.css" rel="stylesheet" />

      <div class="content-body">
        <div class="row">
          <div class="col-xl-6 col-lg-6 col-xs-12">
            <div class="card">
              <div class="card-body">
                <div class="card-block">
                  <div class="media">
                    <div class="media-body text-xs-left">
                      <h3 class="info"><?php echo $this->db->get('masuk')->num_rows() ?></h3>
                      <span>Surat Masuk</span>
                    </div>
                    <div class="media-right media-middle">
                      <i class="icon-email info font-large-2 float-xs-right"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-xs-12">
            <div class="card">
              <div class="card-body">
                <div class="card-block">
                  <div class="media">
                    <div class="media-body text-xs-left">
                      <h3 class="teal"><?php echo $this->db->get('masuk')->num_rows() ?></h3>
                      <span>Surat Keluar</span>
                    </div>
                    <div class="media-right media-middle">
                      <i class="icon-android-drafts teal font-large-2 float-xs-right"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xs-12">
            <div class="card">
              <div class="card-body">
                <div class="card-block">
                 <div id="calendar"></div> 
                </div>
              </div>
            </div>
          </div>
          
        </div>
      </div>


    