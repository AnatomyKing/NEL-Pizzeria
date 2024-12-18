using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations.Schema;
using System.ComponentModel.DataAnnotations;
using System.Linq;
using System.Numerics;
using System.Text;
using System.Threading.Tasks;

namespace NELpizza.Model
{
    [Table("Bestelling")]
    public class Bestelling
    {
        [Key]
        public int BestellingID { get; set; }

        public DateTime Datum { get; set; }

        [EnumDataType(typeof(BestelStatus))]
        public BestelStatus Status { get; set; }

        [ForeignKey("Klant")]
        public int KlantID { get; set; }
        public virtual Klant Klant { get; set; }

        public virtual ICollection<Bestelregel> Bestelregels { get; set; }
    }
}
