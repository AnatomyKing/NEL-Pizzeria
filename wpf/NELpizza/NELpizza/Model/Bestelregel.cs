using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations.Schema;
using System.ComponentModel.DataAnnotations;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace NELpizza.Model
{
    [Table("Bestelregel")]
    public class Bestelregel
    {
        [Key]
        public int BestelregelID { get; set; }

        public int Aantal { get; set; }

        [EnumDataType(typeof(PizzaAfmeting))]
        public PizzaAfmeting Afmeting { get; set; }

        [ForeignKey("Pizza")]
        public int PizzaID { get; set; }
        public virtual Pizza Pizza { get; set; }

        [ForeignKey("Bestelling")]
        public int BestellingID { get; set; }
        public virtual Bestelling Bestelling { get; set; }
    }
}
