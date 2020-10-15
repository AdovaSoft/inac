<?php
$serial = '1232456789';
$date = strtotime('+30days');
$client = 'Mohammad Hafijul Islam';
$address = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.';
$amount = '2000000.56';
$is_cash = false;
$chaque = 123456789;
$chaque_date = strtotime("+15days");
$bank_name = "Dutch Bangla Bank Ltd.";
$branch = "Mohammadpur";
$ac_no = "123456789";
?>
<style>
  td:first-of-type {
    font-weight: normal;
  }
</style>
<h1>Money Receipt</h1>
<table>
  <thead>
  <tr>
    <th width="150" class="text-left">Serial No:</th>
    <td><?= $serial ?></td>
    <td class="text-right" colspan="2"><b>Date: </b> <?= date('d F, Y (D)', $date) ?></td>
  </tr>
  <tr>
    <th class="text-left"><br/>Name:</th>
    <td colspan="3"><br/><span
          style="display:block; width:100%; border-bottom: 2px dotted black;"><?= $client ?></span></td>
  </tr>
  <tr>
    <th class="text-left" style="vertical-align: top;"><br/>Address:</th>
    <td colspan="3"><br/><span style="display:block; width:100%; border-bottom: 2px dotted black;">
                <?= $address ?>
            </span>
    </td>
  </tr>
  </thead>
  <tbody>
  <tr>
    <th colspan="4">
      <div style="margin: auto; font-size: 2rem; padding: 30px">
        Amount:
        <span style="border: 2px solid black; padding: 15px;"><?php
            $fmt = numfmt_create('en_IN', NumberFormatter::CURRENCY);
            echo numfmt_format_currency($fmt, $amount, "BDT") . "\n";
            ?></span>
      </div>
    </th>
  </tr>
  <tr>
    <th class="text-left">
      In Words:
    </th>
    <td>
        <?php
        $taka = (int)$amount;
        $paisa = round((($amount - $taka) * 100), 0);
        $fmt = numfmt_create('en_IN', NumberFormatter::SPELLOUT);
        $taka_spell = ucwords(str_replace('-', ' ', numfmt_format($fmt, $taka)));
        $paisa_spell = ucwords(str_replace('-', ' ', numfmt_format($fmt, $paisa)));

        if ($paisa != 0)
            printf("%s Taka And %s Poysha Only", $taka_spell, $paisa_spell);
        else
            printf("%s Taka Only", $taka_spell);
        ?>
    </td>
  </tr>
  <tr>
    <table>
      <tr>
      <th colspan="3" class="text-left"><br/>
        In Cash/ Cheque/ Pay order/ Draft No:
      </th>
      <td style="border-bottom: 2px dotted black; text-align: center"><br/>
          <?= ($is_cash == false) ? $chaque : null; ?>
      </td>
      <th class="text-center"><br/>
        Dated:
      </th>
      <td style="font-weight: normal;  border-bottom: 2px dotted black; text-align: center"><br/>
          <?= ($is_cash == false) ? date('d/m/Y', $chaque_date) : null; ?>
      </td>
      </tr>
      <tr>
        <th class="text-left" width="125"><br>Bank Name:</th>
        <td colspan="5" style="border-bottom: 2px dotted black; text-align: center"><br><?= $bank_name ?></td>
      </tr>
        <th class="text-left"><br>Branch:</th>
        <td colspan="2" style="border-bottom: 2px dotted black; text-align: center"><br><?= $branch ?></td>
        <th class="text-center"><br>A/C No: </th>
        <td colspan="2" style="border-bottom: 2px dotted black; text-align: center"><br><?= $ac_no ?></td>
      </tr>
    </table>
  </tr>
  </tbody>

</table>