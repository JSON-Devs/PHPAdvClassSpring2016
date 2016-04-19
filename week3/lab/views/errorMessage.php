<?php if ( isset($errorMessage) ) : ?>
<p class="bg-danger"><?php foreach( $errorMessage as $values ) :?>
<?php echo $values;?><br /> 
<?php endforeach; endif; ?></p>

<?php if ( isset($successMessage) ) : ?>
<p class="bg-success"><?php echo $successMessage; ?></p>
<?php endif; ?>