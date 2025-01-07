using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations.Schema;
using System.ComponentModel.DataAnnotations;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace NELpizza.Model
{
    [Table("bestelregels")]
    public class Bestelregel
    {
        [Key]
        public long id { get; set; }

        public int aantal { get; set; }

        [Required]
        public PizzaAfmeting afmeting { get; set; }

        [ForeignKey("pizza")]
        public long pizza_id { get; set; }
        public virtual Pizza? pizza { get; set; }

        [ForeignKey("bestelling")]
        public long bestelling_id { get; set; }
        public virtual Bestelling? bestelling { get; set; }
    }
}
