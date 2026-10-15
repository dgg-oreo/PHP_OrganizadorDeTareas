<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<style>
body { overflow: hidden; }
main { max-width: none; margin: 0; padding: 0; }


#imagen { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; object-fit: fill; z-index: -1; }
</style>

<img id="imagen" src="<?= base_url('img/et.png') ?>" alt="Pendi">

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script>
    gsap.from("#imagen", { opacity: 0, duration: 1.2 });
</script>
<?= $this->endSection() ?>