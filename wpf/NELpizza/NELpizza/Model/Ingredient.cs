using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations.Schema;
using System.ComponentModel.DataAnnotations;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace NELpizza.Model
{
    [Table("Ingredient")]
    public class Ingredient
    {
        [Key]
        public int IngredientID { get; set; }

        public string Naam { get; set; }
        public decimal Prijs { get; set; }
    }
}
