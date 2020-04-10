<section id="basic-examples">
	<div class="row">
		<div class="col-xs-12 mt-1 mb-3">
			<h4 class="">
				Disposisi Surat
			</h4>
			<p>
				Tambah data disposisi surat
			</p>
			<hr>
		</div>
		<div class="col-xs-12">
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
		</div>
	</div>
	<br>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/style.css') ?>">
	<div class="row" style="margin-top: -30px;">
		<div class="col-12">
			<div class="card">
				<div class="card-body " style="padding: 20px;">
					<div class="row">
						<form action="<?php echo base_url('camat/add_disposisi') ?>" method="post">
							
							<div class="col-md-6">
								<div class="form-group">
									<label for="">No Surat</label>
									<select name="no_surat" id="no_surat" onchange="getData()" required="" class="form-control" >
										<option value="" hidden="" >Pilih no surat</option>	
										<?php 
										foreach ($this->db->get('masuk')->result() as $key) {
											?>
											<option value="<?php echo $key->no_surat ?>"><?php echo $key->no_surat ?></option>
											<?php
										}
										?>
									</select>
								</div>
								<div class="form-group">
									<label for="">Surat Dari</label>
									<input type="text" class="form-control" required="" name="dari" id="dari">
								</div>
								<div class="form-group">
									<label for="timesheetinput1">Tanggal Surat</label>
									<div class="position-relative has-icon-right">
										<input type="text"autocomplete="off" class="form-control mydatepicker" placeholder="yyyy/mm/dd" name="tgl_surat" id="tgl_surat" required="">
										<div class="form-control-position">
											<i class="icon-android-calendar" style="font-size: 2em;margin-top: 5px;position: absolute;right: 0px"></i>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="timesheetinput1">Diterima Tanggal</label>
									<div class="position-relative has-icon-right">
										<input type="text"autocomplete="off" class="form-control mydatepicker" placeholder="yyyy/mm/dd" name="tgl_diterima" required="" id="tgl_diterima">
										<div class="form-control-position">
											<i class="icon-android-calendar" style="font-size: 2em;margin-top: 5px;position: absolute;right: 0px"></i>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="">Sifat</label>
									<select name="sifat" id="sifat" required="" class="form-control" id="">
										<option value="" hidden="">Pilih Sifat</option>
										<option>Sangat Segera</option>
										<option>Segera</option>
										<option>Rahasia</option>
									</select>
								</div>
								<div class="form-group">
									<label for="">Perihal</label>
									<textarea name="perihal" id="perihal" required="" class="form-control" style="height: 150px"></textarea>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Diteruskan Kepada</label>
									<input type="text" id="diteruskan" class="form-control" required="" name="diteruskan">
								</div>
								<div class="form-group">
									<label for="">Dengan Hormat Harap</label>
									<select name="dgn_hormat" id="dgn_hormat" required="" class="form-control">
										<option value="" hidden="">Pilih Opsi</option>
										<option>Tanggapan dan saran</option>
										<option>Proses lebih lanjut</option>
										<option>Koordinasi dan konfirmasi</option>
									</select>
								</div>
								<div class="form-group">
									<label for="">Catatan</label>
									<textarea id="catatan" name="catatan" required="" class="form-control" style="height: 150px"></textarea>
								</div>
								<div class="form-group">
									<button class="btn btn-outline-success" onclick="return confirm('Apakah data yang dimasukan telah benar?')">Simpan Data Disposisi</button>
									<a href="<?php echo base_url('camat/disposisi') ?>" class="btn btn-outline-danger">Batal</a>
								</div>
							</div>

						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<script>
	function getData() {
		if ($("#no_surat").val()!="") {
			$.ajax({
				type: "GET",
				dataType:'JSON',
				url: "<?php echo base_url('camat/getData/') ?>"+"/"+$("#no_surat").val(),
				success: function (data) {
					$("#dari").val(data[0]);
					$("#tgl_surat").val(data[1]);
				}
			});
		}
	}
</script>